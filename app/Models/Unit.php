<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property int organisasi_id
 * @property string kode_organisasi
 * @property string nama_organisasi
 * @property int eselon
 * @property string kode_induk_organisasi
 * @property string kode_surat
 * @property string nama_eselon_2
 * @property string nama_eselon_3
 * @property string nama_eselon_1
 * @property string alamat
 * @property string nama_jabatan
 * @property string nama_pejabat
 * @property string nip_pejabat
 * @property boolean allow_to_send
 */
class Unit extends Model
{
    protected $collection = 'unit';

    protected $fillable = [
        'organisasi_id',
        'kode_organisasi',
        'nama_organisasi',
        'eselon',
        'kode_induk_organisasi',
        'kode_surat',
        'nama_eselon_2',
        'nama_eselon_3',
        'nama_eselon_1',
        'alamat',
        'nama_jabatan',
        'nama_pejabat',
        'nip_pejabat',
        'allow_to_send',

    ];
}
