<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MethadologyCategory;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\File;
class MethadologyController extends Controller
{
    public function methadology()
    {
        return view('cms.Methadology.methadology');
    }

    public function methadologyshow(Request $request)
    {
        $search = $request->input('search'); // Ambil nilai dari input pencarian

        // Jika ada parameter pencarian, lakukan pencarian berdasarkan nama atau deskripsi
        if ($search) {
            $methodologyCategories = MethadologyCategory::where('category_name', 'like', '%' . $search . '%')
                ->get();
        } else {
            // Jika tidak ada parameter pencarian, ambil semua data Methadology
            $methodologyCategories = MethadologyCategory::all();
        }

        return view('cms.Methadology.methadology', compact('methodologyCategories'));
    }

    public function deleteMethadology($id)
    {try{
        $methodologyCategories = MethadologyCategory::findOrFail($id);
        $oldImageNamePath = public_path('img/methodology/' . basename($methodologyCategories['flow_image']));
        if($methodologyCategories->delete()){
            //jika berhasil maka akan mengapus image yang digunakan methodology juga
            if(File::exists($oldImageNamePath)){
                File::delete($oldImageNamePath);
            }
        };
        deleteRec("Methadology", Auth::id(), Auth::user()->role_id, $methodologyCategories->category_name);
        return redirect()->route('methadology')->with('success', 'Blog has been deleted successfully.');
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', $th->getMessage());
    }
    }

    public function create()
    {
        return view('cms.Methadology.add');
    }

    public function store(Request $request)
    {try{
        // Validasi data yang diterima dari formulir
        $request->validate([
            'category_title' => 'required|string|max:255',
            'category_name' => 'required|string|max:255',
            'flow_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('flow_image')) {
            $methadology = $request->file('flow_image');
            $methadologyName = Uuid::uuid4() . $methadology->getClientOriginalName();
            $methadologyPath = '/img/methodology/' . $methadologyName;
        }

        // Simpan data portofolio ke database
        $methadologies = new MethadologyCategory([
            'category_title' => $request->category_title,
            'category_name' => $request->category_name,
            'flow_image' => url($methadologyPath)
        ]);

        if($methadologies->save()){
            $methadology->move('img/methodology', $methadologyName);
        }
        addRec("Methadology", Auth::id(), Auth::user()->role_id, $methadologies->category_name);

        // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect()->route('methadology')->with('success', 'Methadology added successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $methodology = MethadologyCategory::findOrFail($id);
        return view('cms.Methadology.edit', compact('methodology'));
    }

    public function update(Request $request, $id)
    {try{
        $methodology = MethadologyCategory::findOrFail($id);
        $methodologyBefore = clone $methodology;

        // Validasi data yang akan diupdate
        $validatedData = $request->validate([
            'category_title' => 'required|string|max:255',
            'category_name' => 'required|string|max:255',
            'flow_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // update data methadology
        $methodology->category_title = $request->input('category_title');
        $methodology->category_name = $request->input('category_name');

        // Periksa apakah ada file gambar yang diupload
        if ($request->hasFile('flow_image')) {
            $methadology = $request->file('flow_image');
            $methadologyName = Uuid::uuid4().$methadology->getClientOriginalName();
            $methadologyPath = '/img/methodology/' . $methadologyName;
            $oldImageNamePath = public_path('img/methodology/'.basename($methodology['flow_image']));
            // Update path gambar portofolio
            $methodology->flow_image = url($methadologyPath);
            // Simpan perubahan
            if($methodology->save()){
                $methadology->move('img/methodology', $methadologyName);
                if(File::exists($oldImageNamePath)&&!(basename($oldImageNamePath) == $methadologyName)){
                    File::delete($oldImageNamePath);
                }
            };
        }

        editRec('Methodology', Auth::id(), Auth::user()->role_id, $methodologyBefore, $methodology, $methodology->category_name);
        // Redirect ke halaman methadology dengan pesan sukses
        return redirect()->route('methadology')->with('success', 'Methadology updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function getMethadology(Request $request)
    {
        $methadologyQuery = MethadologyCategory::all();

        if ($methadologyQuery->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Methadology is not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $methadologyQuery,
        ], 200);
    }

    public function getMethadologyByCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string',
        ]);

        $category = $request->input('category_name');

        $methadologyQuery = MethadologyCategory::where('category_name', $category)->get();

        if ($methadologyQuery->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Methadology is not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $methadologyQuery,
        ], 200);
    }
}
