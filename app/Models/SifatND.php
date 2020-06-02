<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string uraian
 */
class SifatND extends Model
{
    protected $collection = 'sifat_nd';

    protected $fillable = [
        'uraian',
    ];
}
