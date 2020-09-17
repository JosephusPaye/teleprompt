<?php

namespace App\Models;

use App\Models\Presentation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlideImage extends Model
{
    use HasFactory;

    /**
     * The model table
     */
    protected $table = 'slide_images';

    /**
     * Diasable timestamps
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'presentation_id',
        'order',
        'thumbnail_url',
        'path',
    ];

    /**
     * Get the presentation this slide image belongs to.
     */
    public function presentation()
    {
        return $this->belongsTo(Presentation::class);
    }
}
