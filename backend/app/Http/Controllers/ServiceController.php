<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\ServicePageResource;
use Illuminate\Support\Facades\File;
use Ramsey\Uuid\Uuid;

class ServiceController extends Controller
{
    public function service()
    {
        return view('cms.Service.service');
    }

    public function showservice(Request $request)
    {
        $search = $request->input('search');

        if($search) {
            $services = Service::where('name', 'like', '%' . $search . '%')
            ->get();
        } else {
            $services = Service::all();
        }
        // return dd();
        foreach($services as $service){
            $service['image'] = 'img/service/'.basename($service['image']);
        }
        // return dd($services);
        return view('cms.Service.service', compact('services'));
    }

    public function deleteService($id)
    {
        $services = Service::findOrFail($id);
        $oldImagePath = public_path('img/service/') . basename($services['image']);
        $services->delete();
        if(File::exist($oldImagePath)){
            File::delete($oldImagePath);
        }
        return redirect()->route('service')->with('success', 'Service has been deleted successfully.');
    }

    public function create()
    {
        $service = new Service();

        return view('cms.Service.add', compact('service'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string'
        ]);
        $service = new Service([
            'name' => $request->name,
            'desc' => $request->desc,
        ]);
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = Uuid::uuid4().$image->getClientOriginalName();
            $image->move('img/service', $imageName);
            $imagePath = '/img/service'.$imageName;
            $service['image'] = url($imagePath);
        }
        // Simpan data service ke database

        $service->save();

        // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect()->route('service')->with('success', 'Service added successfully.');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('cms.Service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        // Validasi data yang akan diupdate
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
        ]);
        //update data service
        $service->name = $request->input('name');
        $service->desc = $request->input('desc');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = Uuid::uuid4().$image->getClientOriginalName();
            $imagePath = '/img/service'.$imageName;
            $oldImagePath = public_path('img/service/').basename($service['image']);
            $service->image = url($imagePath);
            if($service->save()){
                $image->move('img/service', $imageName);
                if(File::exists($oldImagePath) && !(basename($service['image'])==$imageName)){
                    File::delete($oldImagePath);
                }
            };
        }
        // // Simpan perubahan pada data service
        $service->save();
        // Redirect ke halaman service dengan pesan sukses
        return redirect()->route('service')->with('success', 'Service updated successfully.');
    }

    //API

    public function getServicesByName(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        // Dapatkan nama service
        $requestedName = $request->input('name');

        // Query database untuk mengambil service berdasarkan nama yang sesuai
        $services = Service::where('name', $requestedName)->get();

        // Periksa apakah service ditemukan
        if ($services->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not found',
            ], 404);
        }

        return ServiceResource::collection($services);
    }

    public function getServices(Request $request)
    {
        {
            $services = Service::all();

            if ($services->count() === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service is not found',
                ], 404);
            }

            return ServiceResource::collection($services);
        }
    }

    public function getServicePages()
    {
        // Ambil data dari tabel service_pages
        $servicePages = Service::with('portofolio')->get();
        return ServicePageResource::collection($servicePages);
    }
}
