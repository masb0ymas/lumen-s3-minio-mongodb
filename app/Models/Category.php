<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string uraian
 */
class Category extends Model
{
    protected $fillable = [
        'uraian',
    ];
}
