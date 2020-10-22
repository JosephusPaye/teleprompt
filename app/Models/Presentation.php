<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Facades\Purify;

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
        'settings',
        'content'
    ];

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

        static::saving(function ($presentation) {
            $presentation->content = Purify::clean($presentation->content);
        });
    }

    /**
     * Get the settings attribute.
     */
    public function getSettingsAttribute($value) {
        return json_decode($value ?? []);
    }
}
