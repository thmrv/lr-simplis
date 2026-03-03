<?php

namespace App\Models;

use App\Policies\MediaPolicy;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    /** @use HasFactory<\Database\Factories\MediaFactory> */
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'key',
        'alt',
        'pointer_events',
        'autoplay',
        'locale_values'
    ];

    protected $casts = [
        'locale_values' => 'json',
    ];
}
