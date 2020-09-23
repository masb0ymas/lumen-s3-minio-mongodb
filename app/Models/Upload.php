<?php


namespace App\Models;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="UploadPagination",
 *      description="Upload Pagination",
 *      title="Upload Pagination",
 *      @OA\Property(property="current_page", type="int", example=1),
 *      @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Upload")),
 *      @OA\Property(property="first_page_url", type="string", example="http://localhost:8000/storage?page=1"),
 *      @OA\Property(property="from", type="int", example=1),
 *      @OA\Property(property="last_page", type="int", example=11),
 *      @OA\Property(property="last_page_url", type="string", example="http://localhost:8000/storage?page=11"),
 *      @OA\Property(property="next_page_url", type="string", example="http://localhost:8000/storage?page=12"),
 *      @OA\Property(property="per_page", type="int", example=15),
 *      @OA\Property(property="prev_page_url", type="int", example=null),
 *      @OA\Property(property="to", type="int", example=15),
 *      @OA\Property(property="total", type="int", example=15),
 * )
 */

 /**
 * @OA\Schema(
 *      schema="UploadGenerateURL",
 *      description="Upload Generate URL",
 *      title="Upload Generate URL",
 *      @OA\Property(property="upload_date_expired", type="string", example="2020-07-07T07:18:36.023393Z"),
 *      @OA\Property(property="url", type="string", example="http://103.195.90.201:9000/nadine/1592995553-64c124fc-e0de-4871-b62a-a41447833698.pdf?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=nadine/20200630/us-east-1/s3/aws4_request&X-Amz-Date=20200630T071836Z&X-Amz-SignedHeaders=host&X-Amz-Expires=604800&X-Amz-Signature=996a6a572545f7083ef8cf319cfd7eef8cd80cfe2cc016be8e671e59acd6a2a8"),
 * )
 */

/**
 * @OA\Schema(
 *      @OA\Xml(name="Upload"),
 *      description="Upload Model",
 *      type="object",
 *      title="Upload Model",
 *      @OA\Property(property="id", type="string", example="5ed100e5eb9c10255950cce0"),
 *      @OA\Property(property="file_name", type="file", example="dummy.pdf"),
 *      @OA\Property(property="file_size", type="file", example="79611"),
 *      @OA\Property(property="mimetypes", type="file", example="image/png"),
 *      @OA\Property(property="created_at", type="string", example="2020-05-31T06:41:46.250000Z"),
 *      @OA\Property(property="updated_at", type="string", example="2020-05-31T06:41:46.250000Z"),
 * )
 * @property string file_name
 * @property string file_size
 * @property string mimetypes
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Upload extends Model
{
    protected $collection = 'upload';

    protected $fillable = [
        'file_name',
        'file_size',
        'mimetypes',
    ];
}
