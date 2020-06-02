<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string id
 * @property string uraian
 */
class Action extends Model
{
    protected $fillable = [
        'uraian',
    ];
}
