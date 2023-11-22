<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\CareerPages;
use App\Models\JobPlusValue;
use Illuminate\Http\Request;
use App\Models\JobQualification;
use App\Models\SkillRequirement;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\JobResource;
use App\Http\Resources\CareerPageResource;
use Illuminate\Support\Facades\Auth;

class CareerController extends Controller
{
    public function career()
    {
        return view('cms.Career.career');
    }




    public function showcareer(Request $request)
    {
        $search = $request->input('search'); // Ambil nilai dari input pencarian

        // Jika ada parameter pencarian, lakukan pencarian berdasarkan nama atau deskripsi
        if ($search) {
            $careers = Job::with('jobQualification')->where('name_position', 'like', '%' . $search . '%')
                ->get();
        } else {
            // Jika tidak ada parameter pencarian, ambil semua data career
            $careers = Job::with('jobQualification')->get();
        }

        return view('cms.Career.career', compact('careers'));
    }




    public function deleteSkill($career_id, $skill_id)
    {
        try {
            //code...
        $career = Job::find($career_id);

        // Pastikan career ditemukan
        if (!$career) {
            return redirect()->route('career-edit')->with('error', 'Career not found.');
        }

        // Temukan deliverable berdasarkan ID
        $skill = SkillRequirement::find($skill_id);

        // Pastikan deliverable ditemukan
        if (!$skill) {
            return redirect()->route('career-edit')->with('error', 'Career not found.');
        }
        $skill->delete();
        deleteRec('Skill Requirement', Auth::id(), Auth::User()->role_id, $skill->name, $career->name_position);
        return redirect()->route('career-edit', $career->id)->with('success', 'Career deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }




    public function deletePlusValue($career_id, $plusvalue_id)
    {
        try{
        $career = Job::find($career_id);

        // Pastikan career ditemukan
        if (!$career) {
            return redirect()->route('career')->with('error', 'Career not found.');
        }

        $plusValue = JobPlusValue::find($plusvalue_id);

        if (!$plusValue) {
            return redirect()->route('career')->with('error', 'Plus Value not found.');
        }
        $plusValue->delete();
        deleteRec('Plus Value', Auth::id(), Auth::User()->role_id, $plusValue->name, $career->name_position);
        return redirect()->route('career-edit', $career->id)->with('success', 'Plus Value deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }




    public function updatePlusValue(Request $request, $career_id, $plusvalue_id)
    {
        try{
        // Dapatkan data Plus Value yang akan diupdate
        $plusValue = JobPlusValue::find($plusvalue_id);
        if (!$plusValue) {
            return back()->with('error', 'Plus Value not found.');
        }

        // Update data Plus Value
        $plusValueBefore = clone $plusValue;
        $plusValue->name = $request->input('name');
        $plusValue->save();
        editRec('Plus Value', Auth::id(), Auth::user()->role_id, $plusValueBefore, $plusValue, $plusValue->job->name_position);
        return redirect()->route('career-edit', $career_id)->with('success', 'Plus Value updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }




    public function updateSkill(Request $request, $career_id, $skill_id)
    {
        try{
        // Dapatkan data Skill yang akan diupdate
        $skill = SkillRequirement::find($skill_id);

        if (!$skill) {
            return back()->with('error', 'Skill not found.');
        }

        // Update data Skill
        $skillBefore = clone $skill;
        $skill->name = $request->input('name');
        $skill->save();
        editRec('Skill Requirement', Auth::id(), Auth::user()->role_id, $skillBefore, $skill, $skill->job->name_position);
        return redirect()->route('career-edit', $career_id)->with('success', 'Skill updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }




    public function create()
    {
        $career = new Job();
        $jobQualification = JobQualification::all();
        // $career->save();
        return view('cms.Career.add', compact('career', 'jobQualification'));
    }




    public function store(Request $request)
    {
        try {
            //code...
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'desc' => 'required|string',
                'responsibilities' => 'required|string',
                'link' => 'string|max:255',
                'skillRequirements' => 'required|array',
                'jobPlusValues' => 'nullable|array',
                'jobs_qualification_id' => 'required'
            ]);

            // Simpan data ke dalam tabel jobs
            $career = Job::create([
                'name_position' => $request->input('name'),
                'location' => $request->input('location'),
                'desc' => $request->input('desc'),
                'responsibilities' => $request->input('responsibilities'),
                'link' => $request->input('link'),
                'jobs_qualification_id' => $data['jobs_qualification_id'], // Menggunakan ID dari jobs_qualification yang baru saja dibuat
            ]);

            // Simpan skill ke dalam tabel skill_requirements
            $skillRequirements = $request->input('skillRequirements');
            if (!empty($skillRequirements)) {
                foreach ($skillRequirements as $skill) {
                    SkillRequirement::create([
                        'name' => $skill,
                        'jobs_id' => $career->id,
                    ]);
                }
            }

            // Simpan Plus value ke dalam tabel job_plus_values
            $jobPlusValues = $request->input('jobPlusValues');
            if (!empty($jobPlusValues)) {
                foreach ($jobPlusValues as $plusValue) {
                    JobPlusValue::create([
                        'name' => $plusValue,
                        'jobs_id' => $career->id,
                    ]);
                }
            }
            addRec('Career', Auth::id(), Auth::user()->role_id, $career->name_position);
            // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
            return redirect()->route('career')->with('success', 'Career added successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }




    public function deletecareer($id)
    {
        try{
        $careers = Job::findOrFail($id);

        JobPlusValue::where('jobs_id', $id)->delete();

        SkillRequirement::where('jobs_id', $id)->delete();

        // Hapus pekerjaan
        $careers->delete();
        deleteRec('Career', Auth::id(), Auth::user()->role_id, $careers->name_position);
        return redirect()->route('career')->with('success', 'Career has been deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }




    public function edit($id)
    {
        $career = Job::findOrFail($id);
        $jobQualification = JobQualification::all();
        return view('cms.Career.edit', compact('career', 'jobQualification'));
    }




    public function update(Request $request, $id)
    {
        try {
            //code...
            // return dd($request->all());
        $career = Job::findOrFail($id);
        $careerBefore = clone $career;

        // Validasi data yang dikirim oleh form
        $validatedData = $request->validate([
            'name_position' => 'required|string',
            'location' => 'required|string',
            'desc' => 'required|string',
            'responsibilities' => 'required|string',
            'link' => 'nullable|string',
            'jobs_qualification_id' => 'nullable',
        ]);


        // Update data karier dengan data baru
        $career->update([
            'name_position' => $validatedData['name_position'],
            'location' => $validatedData['location'],
            'desc' => $validatedData['desc'],
            'responsibilities' => $validatedData['responsibilities'],
            'link' => $validatedData['link'],
            'jobs_qualification_id' => $validatedData['jobs_qualification_id'],
        ]);

        $career->save();

        editRec("Career", Auth::id(), Auth::user()->role_id, $careerBefore, $career, $careerBefore->name_position);
        // Redirect ke halaman yang sesuai setelah berhasil mengedit
        return redirect()->route('career')->with('success', 'Career updated successfully');
    } catch (\Throwable $th) {
        error_log($th);
        return redirect()->back()->with('error', $th->getMessage());
    }
    }




    public function addSkillEdit(Request $request, $career_id)
    {
        try {
            //code...
        // validasi data inputan
        $this->validate($request, [
            'skill_name' => 'required|string|max:225',
        ]);

        $career = Job::findOrFail($career_id);

        // Buat skill baru
        $skill = new SkillRequirement();
        $skill->name = $request->input('skill_name');

        $career->skillRequirements()->save($skill);
        addRec('Skill Requirment', Auth::id(), Auth::user()->role_id, $skill->name, $career->name_position);
        return redirect()->route('career-edit', $career->id)->with('success', 'Career has been added successfully.');
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', $th->getMessage());
    }
    }




    public function addPlusValueEdit(Request $request, $career_id)
    {
        try{
        // validasi data inputan
        $this->validate($request, [
            'plusvalue_name' => 'required|string|max:225',
        ]);

        $career = Job::findOrFail($career_id);

        // Buat plusValue baru
        $plusValue = new JobPlusValue();
        $plusValue->name = $request->input('plusvalue_name');

        $career->skillRequirements()->save($plusValue);
        addRec('Plus Value', Auth::id(), Auth::user()->role_id, $plusValue->name, $career->name_position);
        return redirect()->route('career-edit', $career->id)->with('success', 'Plus value has been added successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }




    // API
    public function getCareerPage()
    {
        $careerPage = CareerPages::first(); // Mengambil data halaman karier pertama

        if (!$careerPage) {
            return response()->json(['message' => 'Career page not found'], 404);
        }

        return new CareerPageResource($careerPage);
    }


    public function getCareer(Request $request)
    {
        $location = $request->input('location');
        $name = $request->input('name');

        $query = Job::query();

        if ($location) {
            $query->where('location', $location);
        }

        if ($name) {
            $query->where('name_position', 'like', '%' . $name . '%');
        }

        // Menambahkan pagination dengan batasan 6 data per halaman
        $jobs = $query->paginate(6);

        if ($jobs->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Jobs not found'
            ], 404);
        }

        return JobResource::collection($jobs);
    }
}
