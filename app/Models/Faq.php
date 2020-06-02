<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int category_id
 * @property string pertanyaan
 * @property string jawaban
 * @property int created_by
 */
class Faq extends Model
{
    protected $fillable = [
        'category_id',
        'pertanyaan',
        'jawaban',
        'created_by',
    ];

    /**
     * @return Category|HasOne
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
