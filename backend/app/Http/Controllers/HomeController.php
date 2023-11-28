<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;
use App\Http\Resources\HomeResource;
use App\Models\Service;

class HomeController extends Controller
{
    public function getHome(Request $request)
    {
        $homes = Home::with(['neuronPrograms', 'heroTitleLists', 'testimonials', 'partners', ])->get();
        return HomeResource::collection($homes);
    }
}
