<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string uraian
 */
class BentukND extends Model
{
    protected $collection = 'bentuk_nd';

    protected $fillable = [
        'uraian',
    ];
}
