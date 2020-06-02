<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string uraian
 */
class TingkatKepentingan extends Model
{
    protected $collection = 'tingkat_kepentingan';

    protected $fillable = [
        'uraian',
    ];
}
