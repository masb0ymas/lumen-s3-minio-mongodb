<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string kode_organisasi
 * @property string tujuan_disposisi
 */
class TujuanDisposisi extends Model
{
    protected $collection = 'tujuan_disposisi';

    protected $fillable = [
        'kode_organisasi',
        'tujuan_disposisi',
    ];
}
