<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string uraian
 * @property string singkatan
 * @property boolean state
 * @property string code
 */
class TipeTTD extends Model
{
    protected $collection = 'tipe_ttd';

    protected $fillable = [
        'uraian',
        'singkatan',
        'state',
        'code',
    ];
}
