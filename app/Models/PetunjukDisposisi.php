<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string value
 * @property int order
 */
class PetunjukDisposisi extends Model
{
    protected $collection = 'petunjuk_disposisi';

    protected $fillable = [
        'value',
        'order',
    ];
}
