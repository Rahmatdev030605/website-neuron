<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\ServicePageResource;
use Illuminate\Support\Facades\File;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;

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
        foreach($services as $service){
            $service['image'] = 'img/service/'.basename($service['image']);
        }
        return view('cms.Service.service', compact('services'));
    }

    public function deleteService($id)
    {try{
        $services = Service::findOrFail($id);
        $oldImagePath = public_path('img/service/') . basename($services['image']);
        if($services->delete()){
            if(File::exist($oldImagePath)){
                File::delete($oldImagePath);
            }
        }
        deleteRec('Service', Auth::id(), Auth::user()->role_id, $services->name);
        return redirect()->route('service')->with('success', 'Service has been deleted successfully.');
    }catch(\Throwable $th){
        return redirect()->back()->with('error', $th->getMessage());
    }
    }

    public function create()
    {
        $service = new Service();

        return view('cms.Service.add', compact('service'));
    }

    public function store(Request $request)
    {try{
        // Validasi data yang diterima dari formulir
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $service = new Service([
            'name' => $request->name,
            'desc' => $request->desc,
        ]);
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = Uuid::uuid4().$image->getClientOriginalName();
            $imagePath = '/img/service'.$imageName;
            $service['image'] = url($imagePath);
            // Simpan data service ke database
            if($service->save()){
                // Jika service berhasil disimpan maka gambar akan disimpan juga
                $image->move('img/service', $imageName);
            }
        }else{
            // jika tidak ada image langsung simpan ke database
            $service->save();
        }

        addRec('Service', Auth::id(), Auth::user()->role_id, $service->name);
        // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect()->route('service')->with('success', 'Service added successfully.');
    }catch(\Throwable $th){
        return redirect()->back()->with('error', $th->getMessage());
    }
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $service['image'] = 'img/service/'.basename($service['image']);
        return view('cms.Service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {try{
        $service = Service::findOrFail($id);
        $serviceBefore = clone $service;
        // Validasi data yang akan diupdate
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        //update data service
        $service->name = $request->input('name');
        $service->desc = $request->input('desc');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = Uuid::uuid4().$image->getClientOriginalName();
            $imagePath = '/img/service/'.$imageName;
            $oldImagePath = public_path('img/service/').basename($service['image']);
            $service->image = url($imagePath);
            if($service->save()){
                $image->move('img/service', $imageName);
                if(File::exists($oldImagePath) && !(basename($service['image'])==$imageName)){
                    File::delete($oldImagePath);
                }
            };
        }else{
            // jika tidak ada gambar maka akan langsung disimpan di database
            $service->save();
        }
        editRec('Service', Auth::id(), Auth::user()->role_id, $serviceBefore, $service, $serviceBefore->name);
        // Redirect ke halaman service dengan pesan sukses
        return redirect()->route('service')->with('success', 'Service updated successfully.');
    }catch(\Throwable $th){
        return redirect()->back()->with('error', $th->getMessage());
    }
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
