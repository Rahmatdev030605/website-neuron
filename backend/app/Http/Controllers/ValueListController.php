<?php

namespace App\Http\Controllers;

use App\Models\ValueList;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;


class ValueListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getValueList()
    {
        return view('cms.ValueList.valuelist');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAddValueList()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeValueList(Request $request)
    {
        try {
            //code...
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'desc' => 'required|string',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'about_id' => 'required',
            ]);

            $valuelist = new ValueList();
            $valuelist['title'] = $validatedData['title'];
            $valuelist->desc = $validatedData['desc']; // Ensure you set 'desc'
            $valuelist->about_id = $validatedData['about_id']; // Assign the 'about_id'
            if($request->hasFile('image')){
                $ValueListImage = $request->file('image');
                $ValueListImageName = Uuid::uuid4().$ValueListImage->getClientOriginalName();
                $ValueListImagePath = '/img/valuelist/'. $ValueListImageName;
                $valuelist['image'] = url($ValueListImagePath);
                if($valuelist->save()){
                    $ValueListImage->move('img/valuelist', $ValueListImageName);
                }
            }

            $valuelist->save();
            addRec('ValueList', Auth::id(), Auth::user()->role_id, $valuelist->title);
            return redirect()->route('get-value-list')->with('success', 'Value List Added Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showValueList( Request $request)
    {
            $search = $request->input('search');
            if($search){
                $valuelists = ValueList::query()->where('name', 'like', '%'. $search. '%')->paginate(12);
            }else{
                $valuelists = ValueList::query()->paginate(12);
            }

            foreach($valuelists as $valuelist){
                $valuelist['image'] = asset("img/valuelist/".basename($valuelist['image']));
            }
            return view('cms.ValueList.valuelist', compact('valuelists'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editValueList($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateValueList(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'nullable|string|max:255',
                'desc' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $valuelists = ValueList::findOrFail($id);
            $valuelistBefore = clone $valuelists;

            // Use 'title' consistently
            $valuelists->title = $validatedData['title'];

            if ($request->hasFile('image')) {
                $valuelistImage = $request->file('image');
                $valuelistImageName = Uuid::uuid4() . $valuelistImage->getClientOriginalName();
                $valuelistImagePath = 'img/valuelist/' . $valuelistImageName;

                // Update the image path
                $oldImagePath = public_path('img/valuelist/' . basename($valuelists->image));
                $valuelists->image = $valuelistImagePath;

                if ($valuelists->save()) {
                    $valuelistImage->move('img/valuelist', $valuelistImageName);

                    // Delete the old image if it exists and it's not the same as the new image
                    if (File::exists($oldImagePath) && $oldImagePath !== $valuelistImagePath) {
                        File::delete($oldImagePath);
                    }
                }
            } else {
                // If there is no image, just save the valuelist without updating the image
                $valuelists->save();
            }

            editRec('ValueList', Auth::id(), Auth::user()->role_id, $valuelistBefore, $valuelists, $valuelistBefore->title);
            return redirect()->route('get-value-list')->with('success', 'Value List Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteValueList($id)
    {
        try {
            //code...
            $valuelists = ValueList::findOrFail($id);
            $oldImageNamePath = public_path('img/valuelist/'.basename($valuelists['image']));

            // Kemudian hapus  dan cek apakah berhasil
            if($valuelists->delete()){
                //jika berhasil maka akan mengapus image yang digunakan  juga
                if(File::exists($oldImageNamePath)){
                    File::delete($oldImageNamePath);
                }
            }
            deleteRec('ValueList', Auth::id(), Auth::user()->role_id, $valuelists->title);
            return redirect()->route('get-value-list', compact('valuelist'))->with('success', 'Value List Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        //throw $th;
        }
    }
    }

