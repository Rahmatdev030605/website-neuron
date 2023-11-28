<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;


class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCertificate()
    {

        return view('cms.Certificate.certificate');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCertificate(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'title' => 'required|string|max:255',
                'company' => 'required|string',
                'about_id' => 'required',
            ]);

            $certificate = new Certificate();
            $certificate->title = $validatedData['title'];
            $certificate->company = $validatedData['company'];
            $certificate->about_id = $validatedData['about_id'];

            if ($request->hasFile('image')) {
                $certificateImage = $request->file('image');
                $certificateImageName = Uuid::uuid4() . $certificateImage->getClientOriginalName();
                $certificateImagePath = 'img/certificate/' . $certificateImageName;
                $certificate->image = $certificateImagePath;

                if ($certificate->save()) {
                    $certificateImage->move('img/certificate', $certificateImageName);
                }
            } else {
                $certificate->save();
            }

            addRec('Certificate', Auth::id(), Auth::user()->role_id, $certificate->title);
            return redirect()->route('certificate')->with('success', 'Value List Added Successfully');
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
    public function showCertificate(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $certificates = Certificate::query()->where('title', 'like', '%' . $search . '%')->paginate(12);
        } else {
            $certificates = Certificate::query()->paginate(12);
        }

        foreach ($certificates as $certificate) {
            $certificate['image'] = asset("img/certificate/" . basename($certificate['image']));
        }

        return view('cms.Certificate.certificate', compact('certificates'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateCertificate(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'nullable|string|max:255',
                'company' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $certificate = Certificate::findOrFail($id);
            $certificateBefore = clone $certificate;

            // Use 'title' consistently
            $certificate->title = $validatedData['title'];
            $certificate->company = $validatedData['company'];


            if ($request->hasFile('image')) {
                $certificateImage = $request->file('image');
                $certificateImageName = Uuid::uuid4() . $certificateImage->getClientOriginalName();
                $certificateImagePath = 'img/certificate/' . $certificateImageName;

                // Update the image path
                $oldImagePath = public_path('img/certificate/' . basename($certificate->image));
                $certificate->image = $certificateImagePath;

                if ($certificate->save()) {
                    $certificateImage->move('img/certificate', $certificateImageName);

                    // Delete the old image if it exists and it's not the same as the new image
                    if (File::exists($oldImagePath) && $oldImagePath !== $certificateImagePath) {
                        File::delete($oldImagePath);
                    }
                }
            } else {
                // If there is no image, just save the valuelist without updating the image
                $certificate->save();
            }

            editRec('Certificate', Auth::id(), Auth::user()->role_id, $certificateBefore, $certificate, $certificateBefore->title);
            return redirect()->route('certificate')->with('success', 'Value List Updated Successfully');
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
    public function deleteCertificate($id)
    {
        try {
            //code...
            $certificate = Certificate::findOrFail($id);
            $oldImageNamePath = public_path('img/certificate/' . basename($certificate['image']));

            // Kemudian hapus  dan cek apakah berhasil
            if ($certificate->delete()) {
                //jika berhasil maka akan mengapus image yang digunakan  juga
                if (File::exists($oldImageNamePath)) {
                    File::delete($oldImageNamePath);
                }
            }
            deleteRec('Certificate', Auth::id(), Auth::user()->role_id, $certificate->title);
            return redirect()->route('certificate', compact('certificate'))->with('success', 'Value List Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
            //throw $th;
        }
    }
}
