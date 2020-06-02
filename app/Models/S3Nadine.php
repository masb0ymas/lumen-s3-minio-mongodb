<?php


namespace App\Models;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @OA\Schema(
 *      @OA\Xml(name="S3Nadine"),
 *      description="S3Nadine Model",
 *      type="object",
 *      title="S3Nadine Model",
 *      @OA\Property(property="id", type="string", example="5ed100e5eb9c10255950cce0"),
 *      @OA\Property(property="dokumen", type="file", example="dummy.pdf"),
 *      @OA\Property(property="file_name", type="file", example="dummy.pdf"),
 *      @OA\Property(property="file_size", type="file", example="79611"),
 *      @OA\Property(property="mimetypes", type="file", example="image/png"),
 *      @OA\Property(property="service_name", type="file", example="ND Masuk"),
 *      @OA\Property(property="created_at", type="string", example="2020-05-31T06:41:46.250000Z"),
 *      @OA\Property(property="updated_at", type="string", example="2020-05-31T06:41:46.250000Z"),
 * )
 * @property string file_name
 * @property string file_size
 * @property string mimetypes
 * @property string service_name
 * @property string user_id
 * @property string role_id
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class S3Nadine extends Model
{
    protected $collection = 's3_nadine';

    protected $fillable = [
        'file_name',
        'file_size',
        'mimetypes',
        'service_name',
        'user_id',
        'role_id',
    ];
}
