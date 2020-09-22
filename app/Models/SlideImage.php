<?php

namespace App\Models;

use App\Models\Presentation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['url'];

    /**
     * Get the URL to this file.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }

    /**
     * Get the presentation this slide image belongs to.
     */
    public function presentation()
    {
        return $this->belongsTo(Presentation::class);
    }
}
