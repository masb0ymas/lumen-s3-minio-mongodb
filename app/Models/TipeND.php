<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string uraian
 */
class TipeND extends Model
{
    protected $collection = 'tipe_nd';

    protected $fillable = [
        'uraian',
    ];
}
