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
    ];

    /**
     * Get the slides for this presentation.
     */
    public function slides()
    {
        return $this->hasMany(SlideImage::class);
    }
}
