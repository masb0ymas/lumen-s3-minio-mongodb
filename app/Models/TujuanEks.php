<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string nama
 * @property string jabatan
 * @property string instansi
 * @property string alamat
 */
class TujuanEks extends Model
{
    protected $collection = 'tujuan_eks';

    protected $fillable = [
        'nama',
        'jabatan',
        'instansi',
        'alamat',
    ];
}
