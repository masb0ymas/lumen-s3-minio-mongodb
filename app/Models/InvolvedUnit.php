<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property int unit_id
 * @property int unit_ujuan_id
 * @property int pegawai_id
 * @property string jenis_alur
 */
class InvolvedUnit extends Model
{
    protected $collection = 'involved_unit';

    protected $fillable = [
        'unit_id',
        'unit_tujuan_id',
        'pegawai_id',
        'jenis_alur',
    ];
}
