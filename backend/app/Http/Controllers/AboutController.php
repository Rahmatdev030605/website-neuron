<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Resources\AboutResource;

class AboutController extends Controller
{
    public function getAbout()
    {
        $about = About::with([
            'missionLists',
            'valueLists',
            'certificate'
        ])->first();

        return new AboutResource($about);
    }
}
