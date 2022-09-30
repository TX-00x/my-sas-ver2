<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EmbellishmentStyle extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['public_image_path'];

    public function style()
    {
        return $this->belongsTo(Style::class);
    }

    public function getPublicImagePathAttribute()
    {
        return Storage::url($this->image_path);
    }

    public function embellishmentType()
    {
        return $this->belongsTo(EmbellishmentType::class, 'embellishment_id');
    }
}
