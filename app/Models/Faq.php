<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property int category_id
 * @property string pertanyaan
 * @property string jawaban
 * @property int created_by
 */
class Faq extends Model
{
    protected $fillable = [
        'pertanyaan',
        'jawaban',
    ];
}
