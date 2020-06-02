<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string kop_surat
 */
class CustomKopSurat extends Model
{
    protected $collection = 'custom_kop_surat';

    protected $fillable = [
        'kop_surat',
    ];
}
