<?php

namespace App\Models;

use App\Models\SlideImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
    use HasFactory;

    /**
     * The model table
     */
    protected $table = 'presentations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'code',
        'settings'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Get the slides for this presentation.
     */
    public function slides()
    {
        return $this->hasMany(SlideImage::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($presentation) {
            if ($presentation->settings == null) {
                $presentation->settings = json_encode([
                    'mirrorVertically' => false,
                    'mirrorHorizontally' => false,
                ]);
                $presentation->save();
            }
        });
    }
}
