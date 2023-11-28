<?php

namespace App\Http\Controllers;

use App\Http\Resources\PortofolioResource;
use App\Http\Resources\SuccessPortofolioResource;
use App\Models\Deliverable;
use App\Models\Handle;
use App\Models\Portofolio;
use App\Models\Service;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;

class PortofolioController extends Controller
{
    // show blade portofolio
    public function portofolio()
    {
        return view('cms.Portofolio.portofolio');
    }

    // show portofolio
    public function showportofolio(Request $request)
    {
        $search = $request->input('search'); // Ambil nilai dari input pencarian
        $filter = $request->input('filter'); // Ambil nilai dari input filter
        $sort = $request->input('sort'); // Ambil nilai dari input sort
        // Jika ada parameter pencarian, lakukan pencarian berdasarkan nama atau deskripsi
        if ($search) {
            $portofolios = Portofolio::where('name', 'like', '%' . $search . '%')
                ->orWhere('desc', 'like', '%' . $search . '%')
                ->get();
        }else{
            $portofolios = Portofolio::all();
        }

        if($filter){
            $portofolios = $portofolios->where('service_id', $filter);
        }

        switch($sort){
            case 'ascending':
                $portofolios = $portofolios->sortBy('name');
                break;
            case 'descending':
                $portofolios = $portofolios->sortByDesc('name');
                break;
            case 'newest':
                $portofolios = $portofolios->sortByDesc('created_at');
                break;
            case 'oldest':
                $portofolios = $portofolios->sortBy('created_at');
                break;
            default:
                $portofolios = $portofolios->sortBy('name');;
                break;
        }

        $services = Service::all();
        return view('cms.Portofolio.portofolio', compact('portofolios', 'services','filter', 'sort'));
    }


    // show add portofolio
    public function create()
    {
        $portofolio = new Portofolio();
        $services = Service::all();
        $successProjectOption = [
            'true' => 'Yes',
            'false' => 'No',
        ];
        return view('cms.Portofolio.add', compact('portofolio', 'successProjectOption', 'services'));
    }

    // store portofolio
    public function store(Request $request)
    {
        try{
        // Validasi data yang diterima dari formulir
        $request->validate([
            'name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'our_solution' => 'required|string',
            'details' => 'required|string',
            'created_at' => 'required|date',
            'successProject' => Rule::in(['true', 'false']),
            'service_id' => 'required|numeric'
        ]);


        $successProject = $request->input('successProject');

        // Simpan data portofolio ke database
        $portofolio = new Portofolio([
            'name' => $request->name,
            'customer_name' => $request->customer_name,
            'desc' => $request->desc,
            'our_solution' => $request->our_solution,
            'details' => $request->details,
            'created_at' => $request->created_at,
            'successProject' => $successProject,
        ]);

        // cek apakah ada image
        if ($request->hasFile('image')) {
            $profilePicture = $request->file('image');
            // Image diberi Uuid untuk menghindari penamaan yang sama dengan image lain pada portofolio lain
            $profilePictureName = Uuid::uuid4().$profilePicture->getClientOriginalName();
            $profilePicturePath = '/img/portofolios/' . $profilePictureName;
            $portofolio['image'] = url($profilePicturePath);
            if($portofolio->save()){
                //Jika save berhasil maka image akan disimpan di server
                $profilePicture->move('img/portofolios', $profilePictureName);
            }
        }else{
            // jika tidak ada image maka akan langsung di simpan ke database
            $portofolio->save();
        }
        addRec('Portofolio', Auth::id(), Auth::user()->role_id, $portofolio->name);
        // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect()->route('portofolio')->with('success', 'Portfolio added successfully.');
    }catch(\Throwable $th){
        return redirect()->back()->with('error', $th->getMessage());
    }
    }

    public function edit($id)
    {
        $portofolio = Portofolio::findOrFail($id);

        $services = Service::all();

        $successProjectOption = [
            'true' => 'Yes',
            'false' => 'No',
        ];
        return view('cms.Portofolio.edit', compact('portofolio', 'successProjectOption', 'services'));
    }

    public function update(Request $request, $id)
    {
        try {
            //code...
            $portofolio = Portofolio::findOrFail($id);
            $portfolioBefore = clone $portofolio;

            // Validasi data yang akan diupdate
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'customer_name' => 'required|string|max:255',
                'desc' => 'required|string',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'our_solution' => 'required|string',
                'details' => 'required|string',
                'created_at' => 'required|date',
                'successProject' => 'required|in:true,false',
                'service_id' => 'required|numeric'
            ]);

            // Update data portofolio
            $portofolio->name = $request->input('name');
            $portofolio->customer_name = $request->input('customer_name');
            $portofolio->desc = $request->input('desc');
            $portofolio->our_solution = $request->input('our_solution');
            $portofolio->details = $request->input('details');
            $portofolio->created_at = $request->input('created_at');
            $portofolio->successProject = $request->input(('successProject'));
            $portofolio->service_id = $request->input('service_id');
            // Periksa apakah ada file gambar yang diupload
            if ($request->hasFile('image')) {
                $PortofolioImage = $request->file('image');
                // Image diberi nama untuk menghindari penamaan yang sama dengan image lain di portofolio lain
                $portofolioImageName = Uuid::uuid4().$PortofolioImage->getClientOriginalName();
                $portofolioImagePath = '/img/portofolios/' . $portofolioImageName;
                // Update path gambar portofolio
                $oldImageNamePath = public_path('img/portofolios/'.basename($portofolio['image']));
                $portofolio->image = url($portofolioImagePath);
                if($portofolio->save()){
                    $PortofolioImage->move('img/portofolios', $portofolioImageName);
                    if(File::exists($oldImageNamePath)&&!(basename($oldImageNamePath) == $portofolioImageName)){
                        File::delete($oldImageNamePath);
                    }
                }else{
                    throw new \Exception;
                }
            }else{
                // jika tidak ada image maka akan langsung update
                $portofolio->save();
            }
            editRec('Portofolio', Auth::id(), Auth::user()->role_id, $portfolioBefore, $portofolio, $portfolioBefore->name);
            // Redirect ke halaman portofolio dengan pesan sukses
            return redirect()->route('portofolio')->with('success', 'Portofolio updated successfully.');
        }catch(\Throwable $th){
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    // delete portofolio
    public function deletePortofolio($id)
    {
        try{
        $portofolios = Portofolio::findOrFail($id);
        // Mengambil nama image yang dipakai portofolio
        $oldImageNamePath = public_path('img/portofolios/'.basename($portofolios['image']));

        // Kemudian hapus portofolio dan cek apakah berhasil
        if($portofolios->delete()){
            //jika berhasil maka akan mengapus image yang digunakan portofolio juga
            if(File::exists($oldImageNamePath)){
                File::delete($oldImageNamePath);
            }
        }
        deleteRec('Portofolio', Auth::id(), Auth::user()->role_id, $portofolios->name);
        return redirect()->route('portofolio')->with('success', 'Portofolio has been deleted successfully.');
    }catch(\Throwable $th){
        return redirect()->back()->with('error', $th->getMessage());
    }
    }

    // API

    public function getStartEndYear()
    {
        $startYear = Portofolio::orderBy('created_at', 'asc')->first()->created_at->format('Y');
        $endYear = Portofolio::orderBy('created_at', 'desc')->first()->created_at->format('Y');

        return response()->json([
            'start_year' => $startYear,
            'end_year' => $endYear,
        ]);
    }

    public function getPortofolio(Request $request)
    {
        $request->validate([
            'start_year' => 'nullable|numeric',
            'end_year' => 'nullable|numeric',
            'page' => 'nullable|numeric',
            'sort_by' => 'nullable|in:name,date',
            'filter_by' => 'nullable|in:asc,desc',
        ]);

        $service_id = $request->input('service_id');
        $startYear = $request->input('start_year');
        $endYear = $request->input('end_year');
        $page = $request->input('page', 1);
        $sortBy = $request->input('sort_by', 'date');
        $filterBy = $request->input('filter_by', 'asc');

        $search = $request->input('search');
        if ($search) {
            $portofolioQuery  = Portofolio::where('name', 'like', '%' . $search . '%')
                ->orWhere('desc', 'like', '%' . $search . '%')
                ->get();
        }else{
            $portofolioQuery = Portofolio::where('service_id', $service_id);
        }

        // Buat kueri berdasarkan sort_by dan filter_by
        if (!is_null($startYear)) {
            $portofolioQuery->whereYear('created_at', '>=', $startYear);
        }

        if (!is_null($endYear)) {
            $portofolioQuery->whereYear('created_at', '<=', $endYear);
        }

        if ($sortBy === 'date') {
            $portofolioQuery->orderBy('created_at', $filterBy);
        } else {
            $portofolioQuery->orderBy('name', $filterBy);
        }

        $portofolios = $portofolioQuery->paginate(6);

        $portofolios->appends([
            'service_id' => $service_id,
            'page' => $page,
        ]);

        $portofolios->getCollection()->transform(function ($portofolio) {
            return new PortofolioResource($portofolio);
        });

        if ($portofolios->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Portofolio is not found',
            ], 404);
        }

        return PortofolioResource::collection($portofolios);
    }

    public function getLatestPortfolios()
    {
        // Mengambil 6 portofolio terbaru berdasarkan tanggal pembuatan
        $latestPortfolios = Portofolio::orderBy('created_at', 'desc')->take(6)->get();

        return PortofolioResource::collection($latestPortfolios);
    }

    public function getSuccessPortofolio()
    {
        $successPortofolio = Portofolio::where('successProject', 'true')
            ->limit(3) // Batasi hanya mengambil 3 data teratas
            ->orderBy('id', 'desc') // Urutkan berdasarkan ID secara descending (untuk mengambil yang paling atas)
            ->get();

        return SuccessPortofolioResource::collection($successPortofolio);
    }

    public function getPortfolioById($id)
    {
        $portfolio = Portofolio::findOrFail($id);

        return new PortofolioResource($portfolio);
    }
}
