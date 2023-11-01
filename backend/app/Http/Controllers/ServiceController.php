<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceKey;
use App\Models\Technology;
use App\Models\ServicePages;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\TopServiceResource;
use App\Http\Resources\ServicePageResource;

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




        return view('cms.Service.service', compact('services'));
    }

    public function deleteService($id)
    {
        $services = Service::findOrFail($id);

        $services->delete();

        return redirect()->route('service')->with('success', 'Service has been deleted successfully.');
    }

    public function create()
    {
        $technologies = Technology::all();
        $service = new Service();

        return view('cms.Service.add', compact('service'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',

        ]);


        // Simpan data service ke database
        $service = new Service([
            'name' => $request->name,
            'desc' => $request->desc,
        ]);

        $service->save();
        // Proses deliverables

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

        // // S;impan perubahan pada data service
        $service->save();


        // Periksa apakah ada file gambar yang diuploa
        // Redirect ke halaman service dengan pesan sukses
        return redirect()->route('service')->with('success', 'Service updated successfully.');
    }

    public function addTechnology(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        return redirect()->route('service-edit', ['id' => $service->id])->with('success', 'Technology added to service successfully');
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
        $services = Service::where('name', $requestedName)->with('technologies', 'serviceKeys')->get();

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
        $servicePages = ServicePages::all();

        return ServicePageResource::collection($servicePages);
    }
}
