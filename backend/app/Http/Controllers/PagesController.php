<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\About;
use App\Models\ServicePages;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function pagesShow()
    {
        return view('cms.Pages.pages');
    }
    public function previewHome()
    {
        $dataHome = Home::with('heroTitleLists', 'neuronPrograms')->findOrFail(1);
        $publicImg = "img/home/";
        $dataHome['hero_image'] = $publicImg . basename($dataHome['hero_image']);
        return view('cms.Pages.homeedit', compact('dataHome'));
    }

    public function previewService()
    {
        $pageSetting = ServicePages::findOrFail(1);
        return view('cms.Pages.serviceedit', compact('pageSetting'));
    }

    public function previewAbout()
    {
        $dataAbout = About::findOrFail(1);
        $publicImg = "img/about/";
        $dataAbout['hero_image'] = $publicImg . basename($dataAbout['hero_image']);
        $dataAbout['vision_image'] = $publicImg . basename($dataAbout['vision_image']);
        return view('cms.Pages.aboutedit', compact('dataAbout'));
    }

    public function editHome(Request $req, $id)
    {
        try {
            $reqHome = $req->validate([
                'hero_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'about_title' => 'required|string|max:255',
                'about_desc' => 'required|string',
                'service_title' => 'required|string|max:255',
                'service_desc' => 'required|string',
                'partner_title' => 'required|string|max:255',
                'partner_desc' => 'required|string',
                'article_title' => 'required|string|max:255',
                'article_desc' => 'required|string',
                'hero_title' => 'required|string|max:255',
                'hero_desc' => 'required|string',
                'title' => 'required|string|max:255',
                'desc' => 'required|string',
                'tagline' => 'required|string|max:255',
                'video' => 'required|string|max:255',
            ]);
            if ($req->hasFile('hero_image')) {
                $heroHomeImage = $req->file('hero_image');
                $heroHomeImageName = $heroHomeImage->getClientOriginalName();
                $heroHomeImage->move('img/home', $heroHomeImageName);
                $heroHomeImagePath = '/img/home/' . $heroHomeImageName;
                $reqHome['hero_image'] = url($heroHomeImagePath);
            }

            // Update Home model
            $DBHome = Home::with('neuronPrograms', 'heroTitleLists')->findOrFail($id);
            $oldHomeImageName = basename($DBHome['hero_image']);
            $oldHomeImagePath = public_path('img/home/') . $oldHomeImageName;


            // Update neuronPrograms relationship
            if ($DBHome->neuronPrograms) {
                foreach ($DBHome->neuronPrograms as $neuronProgram) {
                    $neuronProgram->update([
                        'title' => $reqHome['title'],
                        'desc' => $reqHome['desc'],
                        'tagline' => $reqHome['tagline'],
                        'video' => $reqHome['video'],
                    ]);
                }
            }

            // Update heroTitleLists relationship
            if ($DBHome->heroTitleLists) {
                foreach ($DBHome->heroTitleLists as $heroTitleList) {
                    $heroTitleList->update([
                        'hero_title' => $reqHome['hero_title'],
                        'hero_desc' => $reqHome['hero_desc'],
                    ]);
                }
            }


            $DBHome->update($reqHome);

            if (File::exists($oldHomeImagePath) && ($oldHomeImageName != basename($DBHome['hero_image']))) {
                File::delete($oldHomeImagePath);
            }



            return redirect()->route('pages')->with('success', 'Home Pages updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('pages')->with('error', $th->getMessage());
        }
    }



    public function editAbout(Request $req, $id)
    {
        try {
            //code...
            //Validasi data yang diterima dari formulir
            $reqAbout = $req->validate([
                'hero_title' => 'required|string|max:500',
                'hero_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'about_title' => 'required|string|max:500',
                'about_desc' => 'required|string',
                'vision_title' => 'required|string|max:500',
                'vision_desc' => 'required|string|max:500',
                'mission_title' => 'required|string|max:500',
                'mission_list',
                'value_title' => 'required|string|max:500',
                'value_subtitle' => 'required|string|max:500',
                'value_list',
                'part_cert_title' => 'required|string|max:255',
                'part_cert_desc' => 'required|string',
                'partnership_title' => 'required|string|max:255',
                'partner_list',
                'certification_title' => 'required|string|max:255',
                'certificate_list',

            ]);

            $aboutUpdate = About::findOrFail($id);
            $aboutUpdate->hero_title = $reqAbout['hero_title'];
            $aboutUpdate->about_title = $reqAbout['about_title'];
            $aboutUpdate->about_desc = $reqAbout['about_desc'];
            $aboutUpdate->vision_title = $reqAbout['vision_title'];
            $aboutUpdate->vision_desc = $reqAbout['vision_desc'];
            $aboutUpdate->mission_title = $reqAbout['mission_title'];
            $aboutUpdate->value_title = $reqAbout['value_title'];
            $aboutUpdate->value_subtitle = $reqAbout['value_subtitle'];
            $aboutUpdate->part_cert_title = $reqAbout['part_cert_title'];
            $aboutUpdate->part_cert_desc = $reqAbout['part_cert_desc'];
            $aboutUpdate->partnership_title = $reqAbout['partnership_title'];
            $aboutUpdate->certification_title = $reqAbout['certification_title'];

            //Menyimpan gambar hero_image
            $hasHeroImage = false;


            //Menyimpan gambar hero_image
            if ($req->hasFile('hero_image')) {
                $heroImage = $req->file('hero_image');
                $heroImageName = $heroImage->getClientOriginalName();
                $heroImagePath = '/img/about/' . $heroImageName;

                $aboutUpdate->hero_image = url($heroImagePath);
                $hasHeroImage = true;

            }
            //Menyimpan gambar vision_image
            $hasVisionImage = false;
            if ($req->hasFile('vision_image')) {
                $visionImage = $req->file('vision_image');
                $visionImageName = $visionImage->getClientOriginalName();
                $visionImagePath = '/img/about' . $visionImageName;
                $aboutUpdate->vision_image = url($visionImagePath);
                $hasVisionImage = true;


            }
            $oldHeroImageName = basename($aboutUpdate['hero_image']);
            $oldVisionImageName = basename($aboutUpdate['vision_image']);
            $publicImg = public_path('img/about/');
            $oldHeroImagePath = $publicImg . $oldHeroImageName;
            $oldVisionImagePath = $publicImg . $oldVisionImageName;

            if($aboutUpdate->update()){
                if($hasHeroImage){
                    $heroImage->move('img/about', $heroImageName);
                    if(File::exists($oldHeroImagePath) && $oldHeroImageName != basename($aboutUpdate['hero_image'])){File::delete($oldHeroImagePath);}
                }
                if($hasVisionImage){
                    $visionImage->move('img/about', $visionImageName);
                    if(File::exists($oldVisionImagePath) && $oldVisionImageName != basename($aboutUpdate['vision_image'])){File::delete($oldVisionImagePath);}
                }
            }

            return redirect()->route('pages')->with('success', 'About Page Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('pages')->with('error', $th->getMessage());
        }
    }

    public function editService(Request $request, $id)
    {
        try {

            $validatedData = $request->validate([
                'hero_title' => 'required',
                'hero_desc' => 'required',
                'service_title' => 'required',
                'service_subtitle' => 'required',
                'technology_title' => 'required',
                'technology_desc' => 'required',
                'methodology_title' => 'required',
                'methodology_subtitle' => 'required',
                'cta_contact_id' => 'required',
            ]);

            $pageSetting = ServicePages::find($id);

            $pageSetting->update($validatedData);

            return redirect()->route('pages')->with('success', 'Service Page Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('pages')->with('error', 'Failed to Update Service Page');
        }
    }
}
