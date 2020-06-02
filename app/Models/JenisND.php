<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string kode_nd
 * @property string uraian
 */
class JenisND extends Model
{
    protected $collection = 'jenis_nd';

    protected $fillable = [
        'kode_nd',
        'uraian',
    ];
}
