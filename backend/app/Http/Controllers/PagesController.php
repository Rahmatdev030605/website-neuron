<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\About;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function pagesShow(){
        return view('cms.Pages.pages');
    }

    public function previewHome(){
        $dataHome = Home::findOrFail(1);
        return view('cms.Pages.homeedit',compact('dataHome'));
    }

    public function previewAbout(){
        $dataAbout = About::findOrFail(1);
        $publicImg = "img/about/";
        $dataAbout['hero_image'] = $publicImg.basename($dataAbout['hero_image']);
        $dataAbout['activity_image'] = $publicImg.basename($dataAbout['activity_image']);
        $dataAbout['vision_image'] = $publicImg.basename($dataAbout['vision_image']);
        $dataAbout['mission_image'] = $publicImg.basename($dataAbout['mission_image']);
        return view('cms.Pages.aboutedit',compact('dataAbout'));
    }

    public function editHome(Request $req, $id){
        $reqHome = $req->validate([
            'hero_title1' => 'required|string|max:255',
            'hero_title2' => 'required|string|max:255',
            'hero_title3' => 'required|string|max:255',
            'hero_desc' => 'required|string|max:255',
            'about_project' => 'required|string|max:20',
            'about_experience' => 'required|string|max:20',
            'about_desc' => 'required|string|max:255',
            'about_title' => 'required|string|max:255',
            'about_ilustration' => '', //!NEED VALIDATE
            'title_service'=> 'required|string|max:255',
            'title_project'=> 'required|string|max:255',
            'title_product'=> 'required|string|max:255',
            'title_partner'=> 'required|string|max:255',
            'title_articles'=> 'required|string|max:255',
            'title_certificate'=> 'required|string|max:255'
        ]);

        $DBHome = Home::findOrFail($id);
        $DBHome->update($reqHome);
        return redirect()->route('pages');
    }


    public function editAbout(Request $req, $id){
        try {
            //code...
            //Validasi data yang diterima dari formulir
            $reqAbout = $req->validate([
                'hero_title' => 'required|string|max:500',
                'hero_desc'  => 'required|string|max:500',
                'hero_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'activity_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'vision_title' => 'required|string|max:500',
                'vision_subtitle' => 'required|string|max:500',
                'vision_desc' => 'required|string|max:500',
                'vision_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'mission_title' => 'required|string|max:500',
                'mission_subtitle' => 'required|string|max:500',
                'mission_desc' => 'required|string|max:500',
                'mission_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'value_title' => 'required|string|max:500',
                'value_subtitle' => 'required|string|max:500',
                'director_title' => 'required|string|max:500',
                'director_subtitle' => 'required|string|max:500',
                'strategic_title' => 'required|string|max:500',
                'strategic_subtitle' => 'required|string|max:500',
            ]);

        //Menyimpan gambar hero_image
            if($req->hasFile('hero_image')){
                $heroImage = $req->file('hero_image');
                $heroImageName = $heroImage->getClientOriginalName();
                $heroImage->move('img/about', $heroImageName);
                $heroImagePath = '/img/about/'.$heroImageName;
                $reqAbout['hero_image'] = url($heroImagePath);
            }
            //Menyimpan gambar activity_image
            if($req->hasFile('activity_image')){
                $activityImage = $req->file('activity_image');
                $activityImageName = $activityImage->getClientOriginalName();
                $activityImage->move('img/about', $activityImageName);
                $activityImagePath = '/img/about/'.$activityImageName;
                $reqAbout['activity_image'] = url($activityImagePath);
            }
            //Menyimpan gambar vision_image
            if($req->hasFile('vision_image')){
                $visionImage = $req->file('vision_image');
                $visionImageName = $visionImage->getClientOriginalName();
                $visionImage->move('img/about', $visionImageName);
                $visionImagePath = '/img/about'.$visionImageName;
                $reqAbout['vision_image'] = url($visionImagePath);
            }
            //Menyimpan mission_image
            if($req->hasFile('mission_image')){
                $missionImage = $req->file('mission_image');
                $missionImageName = $missionImage->getClientOriginalName();
                $missionImage->move('img/about', $missionImageName);
                $missionImagePath = 'img/about'.$missionImageName;
                $reqAbout['mission_about'] = url($missionImagePath);
            }
            $aboutUpdate = About::findOrFail($id);
            $oldHeroImageName = basename($aboutUpdate['hero_image']);
            $oldActivityImageName = basename($aboutUpdate['activity_image']);
            $oldVisionImageName = basename($aboutUpdate['vision_image']);
            $oldMissionImageName = basename($aboutUpdate['mission_image']);
            $publicImg = public_path('img/about/');
            $oldHeroImagePath = $publicImg.$oldHeroImageName;
            $oldActivityImagePath = $publicImg.$oldActivityImageName;
            $oldVisionImagePath = $publicImg.$oldVisionImageName;
            $oldMissionImagePath = $publicImg.$oldMissionImageName;

            $aboutUpdate->update($reqAbout);
            if(File::exists($oldHeroImagePath) && $oldHeroImageName != basename($aboutUpdate['hero_image'])){File::delete($oldHeroImagePath);}
            if(File::exists($oldActivityImagePath) && $oldActivityImageName != basename($aboutUpdate['activity_image'])){File::delete($oldActivityImagePath);}
            if(File::exists($oldVisionImagePath) && $oldVisionImageName != basename($aboutUpdate['vision_image'])){File::delete($oldVisionImagePath);}
            if(File::exists($oldMissionImagePath) && $oldMissionImageName != basename($aboutUpdate['mission_image'])){File::delete($oldMissionImagePath);}
            return redirect()->route('pages');
        } catch (\Throwable $th) {
            return dd($th);
        }
    }
}
