<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(int $advertId)
 * @method static where(string $string, $id)
 * @method static create(array $payload)
 *
 * @property int user_id
 * @property string name
 * @property mixed from
 * @property mixed to
 * @property float total_budget
 * @property float daily_budget
 * @property mixed banner_image_path
 * @property int id
 */
class Advert extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable  = [
        "user_id",
        "name",
        "from",
        "to",
        "total_budget",
        "daily_budget",
        "banner_image_path",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
