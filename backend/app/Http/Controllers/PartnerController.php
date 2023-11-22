<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;
class PartnerController extends Controller
{
    // Show Partner
    public function showPartner(Request $request){
        $search = $request->input('search');
        if($search){
            $partners = Partner::query()->where('name', 'like', '%'. $search. '%')->paginate(12);
        }else{
            $partners = Partner::query()->paginate(12);
        }

        foreach($partners as $partner){
            $partner['image'] = asset("img/partner/".basename($partner['image']));
        }
        return view('cms.Partner.partner', compact('partners'));
    }

    // Store Partner
    public function storePartner(Request $request){
        try {
            //code...
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $partner = new Partner();
            $partner['name'] = $validatedData['name'];
            if($request->hasFile('image')){
                $partnerImage = $request->file('image');
                // Image diberi UUID untuk menghindari penamaan yang sama dengan image lain di portofolio lain
                $partnerImageName = Uuid::uuid4().$partnerImage->getClientOriginalName();
                $partnerImagePath = '/img/partner/'. $partnerImageName;
                $partner['image'] = url($partnerImagePath);
                if($partner->save()){
                    $partnerImage->move('img/partner', $partnerImageName);
                }
            }
            $partner->save();
            addRec('Partner', Auth::id(), Auth::user()->role_id, $partner->name);
            return redirect()->route('partner')->with('success', 'Partner Added Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function updatePartner(Request $request, $id){
        try {
            //code...
            $validatedData = $request->validate([
                'name' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $partner = Partner::findOrFail($id);
            $partnerBefore = clone $partner;
            $partner->name = $validatedData['name'];

            if ($request->hasFile('image')) {
                $partnerImage = $request->file('image');
                // Image diberi nama untuk menghindari penamaan yang sama dengan image lain di portofolio lain
                $partnerImageName = Uuid::uuid4().$partnerImage->getClientOriginalName();
                $partnerImagePath = '/img/partner/' . $partnerImageName;
                // Update path gambar portofolio
                $oldImageNamePath = public_path('img/partner/'.basename($partner['image']));
                $partner->image = url($partnerImagePath);
                if($partner->save()){
                    $partnerImage->move('img/partner', $partnerImageName);
                    if(File::exists($oldImageNamePath)&&!($oldImageNamePath == $partnerImageName)){
                        File::delete($oldImageNamePath);
                    }
                }
            }else{
                // jika tidak ada image maka akan langsung update
                $partner->save();
            }
            editRec('Partner', Auth::id(), Auth::user()->role_id,$partnerBefore, $partner, $partnerBefore->name);
            return redirect()->route('partner')->with('success', 'Partner Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    // Delete Partner
    public function deletePartner($id){
        try {
            //code...
            $partner = Partner::findOrFail($id);
            $oldImageNamePath = public_path('img/partner/'.basename($partner['image']));

            // Kemudian hapus partner dan cek apakah berhasil
            if($partner->delete()){
                //jika berhasil maka akan mengapus image yang digunakan partner juga
                if(File::exists($oldImageNamePath)){
                    File::delete($oldImageNamePath);
                }
            }
            deleteRec('Partner', Auth::id(), Auth::user()->role_id, $partner->name);
            return redirect()->route('partner')->with('success', 'Partner Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        //throw $th;
        }
    }


}
