<?php

namespace App\Http\Controllers;

use App\Repositories\S3Nadine\S3NadineRepository;
use App\Services\S3Nadine\S3NadineService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class GenerateFile {
    public $upload_date_expired;
    public $url;
}

class MinIOController extends Controller
{
    /**
     * @var S3NadineService
     */
    protected $s3NadineService;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->s3NadineService = new S3NadineService(new S3NadineRepository());
    }

    /**
     * @OA\Get(
     *      tags={"S3Nadine"},
     *      path="/storage",
     *      summary="List all storage",
     *      @OA\Response(
     *          response=200,
     *          description="succses",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="success retrieve storage"),
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/S3Nadine")),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="something went wrong"),
     *              @OA\Property(property="errors", type="string", example="i am wrong..."),
     *          ),
     *      ),
     * )
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->s3NadineService->all();

        return response()->json([
            'message' => 'Success retrieve storage data',
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *      tags={"S3Nadine"},
     *      path="/storage/files",
     *      summary="List all files on storage",
     *      @OA\Response(
     *          response=200,
     *          description="succses",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="success retrieve storage"),
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/S3Nadine")),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="something went wrong"),
     *              @OA\Property(property="errors", type="string", example="i am wrong..."),
     *          ),
     *      ),
     * )
     * @return JsonResponse
     */
    public function list_files()
    {
        $disk = Storage::disk('minio');
        $data = $disk->files();

        return response()->json([
            'message' => 'Success retrieve storage data',
            'data' => $data,
        ]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function get_one(string $id)
    {
        $data = $this->s3NadineService->findById($id);

        if ($data === null) {
            return response()->json([
                'message' => 'File Not Found',
                'success' => false,
            ], 404);
        }

        $data = $this->generate_url_file($data->file_name);

        return response()->json([
            'message' => 'Success generate url file',
            'data' => $data,
        ]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function generate_url_file(string $filename)
    {
        $date_now = Carbon::now('Asia/Jakarta');
        $one_week = $date_now->add(7, 'day');

        $disk = Storage::disk('minio');
        $getAdapter = $disk->getDriver()->getAdapter();

        if ($disk->exists($filename)) {

            $command = $getAdapter->getClient()->getCommand('GetObject', [
                'Bucket'    => Config::get('filesystems.disks.minio.bucket'),
                'Key'       => $filename,
                // 'Key'       => $getAdapter->getPathPrefix().'/images/asd.png',
                // 'ResponseContentDisposition' => 'attachment;'//for download
            ]);

            $request = $getAdapter->getClient()->createPresignedRequest($command, '+7 days');

            $generate_url = $request->getUri();
            $url = urldecode($generate_url);
            // echo $generate_url;

            // create object
            $data_generate = new GenerateFile();
            $data_generate->upload_date_expired = $one_week;
            $data_generate->url = $url;

            return $data_generate;
        }

        // return response()->json([
        //     'message' => 'File Not Found',
        //     'success' => false,
        // ], 404);
    }

    /**
     ** @OA\Post(
     *      tags={"S3Nadine"},
     *      path="/storage",
     *      summary="Upload file to storage",
     *      @OA\RequestBody(
     *         description="Body",
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(property="dokumen", ref="#/components/schemas/S3Nadine/properties/dokumen"),
     *              @OA\Property(property="service_name", ref="#/components/schemas/S3Nadine/properties/service_name"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="succses",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/S3Nadine"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="client error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="validation error"),
     *              @OA\Property(property="errors", type="array", @OA\Items(example={"dokumen"="the dokumen field is required"})),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="something went wrong"),
     *              @OA\Property(property="errors", type="string", example="i am wrong..."),
     *          ),
     *      ),
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'dokumen' => 'required|max:10240|mimes:txt,doc,docx,xls,xlsx,pdf,png,jpg,jpeg'
        ]);

        $disk = Storage::disk('minio');

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();
            $filePath = time() . '-' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            // $filePath = 'images/' . $name;
            $dataS3 = $disk->put($filePath, file_get_contents($file));

            $data = $this->s3NadineService->create([
                'file_name'     => $filePath,
                'file_size'     => $fileSize,
                'mimetypes'     => $mimeType,
                'service_name'  => 'Nota Dinas',
            ]);

            $data_generate = $this->generate_url_file($data->file_name);
        }

        return response()->json([
            'message' => 'File uploaded successfully',
            'success' => $dataS3,
            'data' => $data,
            'generate_url' => $data_generate,
        ]);
    }

    /**
     ** @OA\Put(
     *      tags={"S3Nadine"},
     *      path="/storage/{id}",
     *      summary="Update file to storage",
     *      @OA\Parameter(
     *          description="storage id",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\RequestBody(
     *         description="Body",
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(property="dokumen", ref="#/components/schemas/S3Nadine/properties/dokumen"),
     *              @OA\Property(property="service_name", ref="#/components/schemas/S3Nadine/properties/service_name"),
     *         ),
     *     ),
     *      @OA\Response(
     *          response=201,
     *          description="succses",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/S3Nadine"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="client error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="failed update storage"),
     *              @OA\Property(property="errors", type="string", example="storage not found"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="client error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="validation error"),
     *              @OA\Property(property="errors", type="array", @OA\Items(example={"dokumen"="the dokumen field is required"})),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="something went wrong"),
     *              @OA\Property(property="errors", type="string", example="i am wrong..."),
     *          ),
     *      ),
     * )
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'dokumen' => 'required|max:10240|mimes:txt,doc,docx,xls,xlsx,pdf,png,jpg,jpeg'
        ]);

        $dataStorage = $this->s3NadineService->findById($id);

        $filename = $dataStorage->file_name;
        $disk = Storage::disk('minio');

        // check file
        if ($disk->exists($filename)) {

            // file upload
            if ($request->hasFile('dokumen')) {
                $file = $request->file('dokumen');
                $fileSize = $file->getSize();
                $mimeType = $file->getMimeType();
                $filePath = time() . '-' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                // $filePath = 'images/' . $name;
                $dataS3 = $disk->put($filePath, file_get_contents($file));

                $data = $this->s3NadineService->update($id, [
                    'file_name'     => $filePath,
                    'file_size'     => $fileSize,
                    'mimetypes'     => $mimeType,
                    'service_name'  => 'Nota Dinas',
                ]);

                $data_generate = $this->generate_url_file($data->file_name);
            }

            return response()->json([
                'message' => 'File uploaded successfully',
                'success' => $dataS3,
                'data' => $data,
                'generate_url' => $data_generate,
            ]);
        }

        return response()->json([
            'message' => 'File Not Found',
            'success' => false,
        ], 404);
    }

    /**
     ** @OA\Delete(
     *      tags={"S3Nadine"},
     *      path="/storage/{id}",
     *      summary="Delete file on storage",
     *      @OA\Parameter(
     *          description="storage id",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="succses",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="success delete storage"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="client error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="failed delete storage"),
     *              @OA\Property(property="errors", type="string", example="storage not found"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="something went wrong"),
     *              @OA\Property(property="errors", type="string", example="i am wrong..."),
     *          ),
     *      ),
     * )
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        $data = $this->s3NadineService->findById($id);

        $filename = $data->file_name;
        $disk = Storage::disk('minio');

        // delete from S3 minio
        if ($disk->exists($filename)) {
            $dataS3 = $disk->delete($filename);

            // delete from DB
            $status = $this->s3NadineService->delete($id);

            if (!$status) { // false
                return response()->json([
                    'message' => 'File Not Found',
                    'success' => false,
                ], 404);
            }

            return response()->json([
                'message' => 'File was deleted successfully',
                'success' => $dataS3,
            ]);
        }

        return response()->json([
            'message' => 'File Not Found',
            'success' => false,
        ], 404);
    }
}
