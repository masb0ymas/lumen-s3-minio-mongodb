<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string nama
 * @property string unit
 * @property int created_by
 * @property string created_kode_org
 */
class GroupingTujuan extends Model
{
    protected $collection = 'grouping_tujuan';

    protected $fillable = [
        'nama',
        'unit',
        'created_by',
        'created_kode_org',
    ];
}
