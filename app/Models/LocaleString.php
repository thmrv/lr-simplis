<?php

namespace App\Models;

use App\Policies\LocaleStringPolicy;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocaleString extends Model
{
    /** @use HasFactory<\Database\Factories\LocaleStringFactory> */
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'key',
        'default',
        'locale_values'
    ];

    protected $casts = [
        'locale_values' => 'json',
    ];
}
