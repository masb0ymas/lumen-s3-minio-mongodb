<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function get_all(Request $request)
    {
        $data = Upload::query();

        return response()->json([
            'data' => $data->search($request)
        ]);
    }

    public function get_one(string $id)
    {
        $data = Upload::find($id);

        return response()->json([
            'data' => $data
        ]);
    }

    public function redirect_url(string $id)
    {
        $data = Upload::find($id);

        if ($data === null) {
            return response()->json([
                'message' => 'Dokumen tidak ditemukan',
                'success' => false,
            ], 404);
        }

        $file_name = $data['file_name'];
        $mimetypes = $data['mimetypes'];

        $data_generate = $this->generate_url($file_name, $mimetypes);

        return redirect($data_generate['url']);
    }

    private function rules()
    {
        $rules = [
            'dokumen' => 'required|max:10240|mimes:doc,docx,xlsx,xls,ppt,pptx,pdf,zip,png,jpg,jpeg',
        ];

        return $rules;
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules());

        $disk = Storage::disk('minio');

        if ($request->hasFile('dokumen')) {
            $file       = $request->file('dokumen');
            $fileSize   = $file->getSize();
            $mimeType   = $file->getMimeType();

            # File Format sesuai ext
            $file_name_storage = time() . '-' . Str::uuid() . '.' .  $file->getClientOriginalExtension();

            // Upload ke Minio
            $dataS3 = $disk->put($file_name_storage, file_get_contents($file));

            $data = Upload::create([
                'file_name'     => $file_name_storage,
                'file_size'     => $fileSize,
                'mimetypes'     => $mimeType,
            ]);

            $data_generate = $this->generate_url($data->file_name, $data->mimetypes);
        }

        return response()->json([
            'message'       => 'Dokumen berhasil diunggah ke minio',
            'data_upload'   => $dataS3,
            'data'          => $data,
            'generate_url'  => $data_generate,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, $this->rules());

        $disk = Storage::disk('minio');

        $data = Upload::find($id);

        // check file di storage
        if ($disk->exists($data['file_name'])) {
            // check file upload
            if ($request->hasFile('dokumen')) {
                $file       = $request->file('dokumen');
                $fileSize   = $file->getSize();
                $mimeType   = $file->getMimeType();

                # File Format sesuai ext
                $file_name_storage = time() . '-' . Str::uuid() . '.' .  $file->getClientOriginalExtension();

                // Upload ke Minio
                $dataS3 = $disk->put($file_name_storage, file_get_contents($file));

                // update data
                $data->file_name = $file_name_storage;
                $data->file_size = $fileSize;
                $data->mimetypes = $mimeType;
                $data->save();

                $data_generate = $this->generate_url($data->file_name, $data->mimetypes);
            }

            return response()->json([
                'message'       => 'Dokumen berhasil diperbarui',
                'data_upload'   => $dataS3,
                'data'          => $data,
                'generate_url'  => $data_generate,
            ]);
        }

        return response()->json([
            'message' => 'Dokumen tidak ditemukan',
        ], 404);
    }

    public function destroy(string $id)
    {
        $disk = Storage::disk('minio');

        $data = Upload::find($id);
        $nama_file = $data['file_name'];

        // check file di storage
        if ($disk->exists($nama_file)) {

            // delete from bucket
            $disk->delete($nama_file);

            // delete from database
            $data->delete();

            return response()->json([
                'message' => 'Dokumen berhasil dihapus',
            ]);
        }

        return response()->json([
            'message' => 'Dokumen tidak ditemukan',
        ], 404);
    }
}
