<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string name
 * @property string data
 * @property string image
 * @property string attribute
 * @property string kode_organisasi
 * @property string peruntukan
 * @property boolean state
 * @property string template_nota_pengantar
 * @property string data2
 */
class Template extends Model
{
    protected $fillable = [
        'name',
        'data',
        'image',
        'attribute',
        'kode_organisasi',
        'peruntukan',
        'state',
        'template_nota_pengantar',
        'data2',
    ];
}
