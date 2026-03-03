<?php

namespace App\Http\Controllers;

use App\Models\LocaleString;
use Inertia\Inertia;

abstract class Controller
{
    public function index()
    {
        return Inertia::render('Welcome');
    }
}
