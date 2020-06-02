<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property int organisasi_id
 * @property string kode_organisasi
 * @property string nama_jabatan
 * @property int eselon
 * @property string kode_induk_organisasi
 * @property string kode_surat
 * @property string eselon_2
 * @property string eselon_3
 * @property boolean is_aktif
 * @property string no_sk
 * @property string nama_tim
 * @property string alamat
 * @property string nama_pejabat
 * @property string kop_surat
 * @property boolean allow_to_send
 * @property int unit_created
 * @property int user_created
 * @property int user_updated
 */
class Tim extends Model
{
    protected $collection = 'tim';

    protected $fillable = [
        'organisasi_id',
        'kode_organisasi',
        'nama_jabatan',
        'eselon',
        'kode_induk_organisasi',
        'kode_surat',
        'eselon_2',
        'eselon_3',
        'is_aktif',
        'no_sk',
        'nama_tim',
        'alamat',
        'nama_pejabat',
        'kop_surat',
        'allow_to_send',
        'unit_created',
        'user_created',
        'user_updated',
    ];
}
