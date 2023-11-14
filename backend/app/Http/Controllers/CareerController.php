<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\CareerPages;
use App\Models\JobPlusValue;
use Illuminate\Http\Request;
use App\Models\JobQualification;
use App\Models\SkillRequirement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\JobResource;
use App\Http\Resources\CareerPageResource;
use Location;

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

        $JobQualifications   = JobQualification::all();

        return view('cms.Career.career', compact('careers', 'JobQualifications'));
    }

    public function deleteSkill($career_id, $skill_id)
    {
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
        deleteRec('Skill', Auth::id(), Auth::User()->role_id, $skill);
        return redirect()->route('career-edit', $career->id)->with('success', 'Career deleted successfully.');
    }

    public function deletePlusValue($career_id, $plusvalue_id)
    {
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
        deleteRec('Plus Value', Auth::id(), Auth::User()->role_id, $plusValue);
        return redirect()->route('career-edit', $career->id)->with('success', 'Plus Value deleted successfully.');
    }

    public function updatePlusValue(Request $request, $career_id, $plusvalue_id)
    {
        // Dapatkan data Plus Value yang akan diupdate
        $plusValue = JobPlusValue::find($plusvalue_id);
        $career = Job::findOrFail($career_id);

        if (!$plusValue) {
            return back()->with('error', 'Plus Value not found.');
        }

        // Update data Plus Value
        $plusValueBefore = $plusValue->name;
        $plusValue->name = $request->input('name');
        $plusValue->save();
        editRec('Plus Value', Auth::id(), Auth::user()->role_id, $plusValueBefore, $plusValue->name);

        return redirect()->route('career-edit', $career->id)->with('success', 'Plus value has been update successfully.');
    }

    public function updateSkill(Request $request, $career_id, $skill_id)
    {
        // Dapatkan data Skill yang akan diupdate
        $skill = SkillRequirement::find($skill_id);
        $career = Job::findOrFail($career_id);

        if (!$skill) {
            return back()->with('error', 'Skill not found.');
        }

        // Update data Skill

        $skillNameBefore = $skill->name;
        $skill->name = $request->input('name');
        $skill->save();
        editRec('Skill', Auth::id(), Auth::user()->role_id,$skillNameBefore, $skill->name);


        return redirect()->route('career-edit', $career->id)->with('success', 'Skill updated successfully.');
    }

    public function create()
    {
        $career = new Job();
        return view('cms.Career.add', compact('career'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'desc' => 'required|string',
            'responsibilities' => 'required|string',
            'gender' => 'required|in:Man,Female,Man/Female',
            'domicile' => 'required|string|max:255',
            'education' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'other' => 'required|string',
            'link' => 'string|max:255',
            'skillRequirements' => 'required|array',
            'jobPlusValues' => 'nullable|array',
        ]);

        // Simpan data ke dalam tabel jobs_qualification
        $qualification = new JobQualification([
            'gender' => $request->input('gender'),
            'domicile' => $request->input('domicile'),
            'education' => $request->input('education'),
            'major' => $request->input('major'),
            'other' => $request->input('other'),
        ]);

        $qualification->save();
        addRec('Qualification', Auth::id(), Auth::user()->role_id, $qualification);

        // Simpan data ke dalam tabel jobs
        $career = new Job([
            'name_position' => $request->input('name'),
            'location' => $request->input('location'),
            'desc' => $request->input('desc'),
            'responsibilities' => $request->input('responsibilities'),
            'link' => $request->input('link'),
            'jobs_qualification_id' => $qualification->id, // Menggunakan ID dari jobs_qualification yang baru saja dibuat
        ]);

        $career->save();
        addRec('Career', Auth::id(), Auth::user()->role_id, $career);

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

        // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect()->route('career')->with('success', 'Career added successfully.');
    }

    public function deletecareer($id)
    {
        $careers = Job::findOrFail($id);

        JobPlusValue::where('jobs_id', $id)->delete();

        SkillRequirement::where('jobs_id', $id)->delete();

        // Hapus pekerjaan
        $careers->delete();
        deleteRec('Career', Auth::id(), Auth::user()->role_id, $careers);

        $careers->jobQualification()->delete();
        deleteRec('Job Qualification in career', Auth::id(), Auth::user()->role_id, $careers->jobQualification);

        return redirect()->route('career')->with('success', 'Career has been deleted successfully.');
    }

    public function edit($id)
    {
        $career = Job::findOrFail($id);
        return view('cms.Career.edit', compact('career'));
    }

    public function update(Request $request, $id)
    {

        // return dd($request->all());
        //code...
        $career = Job::findOrFail($id);

        // Update data pada model Job
        $career->update($request->only(['name_position', 'desc', 'responsibilities', 'link']));
        editRec('Career', Auth::id(), Auth::user()->role_id, $career->id, $career);

    // Pastikan kualifikasi dengan $id ditemukan
    $qualification = JobQualification::where('id', $id)->firstOrFail();

    // Update data pada model JobQualification4

    $qualification->update($request->only(['gender', 'domicile', 'education', 'major', 'other']));

    editRec('Qualification', Auth::id(), Auth::user()->role_id, $qualification->id, $qualification);

        return redirect()->route('career')->with('success', 'Career updated successfully');
    }


    public function addSkillEdit(Request $request, $career_id)
    {
        // validasi data inputan
        $this->validate($request, [
            'skill_name' => 'required|string|max:225',
        ]);

        $career = Job::findOrFail($career_id);

        // Buat skill baru
        $skill = new SkillRequirement();
        $skill->name = $request->input('skill_name');

        $career->skillRequirements()->save($skill);
        addRec('Skill', Auth::id(), Auth::user()->role_id, $skill->name);

        return redirect()->route('career-edit', $career->id)->with('success', ' has been update successfully.');
    }

    public function addPlusValueEdit(Request $request, $career_id)
    {
        // validasi data inputan
        $this->validate($request, [
            'plusvalue_name' => 'required|string|max:225',
        ]);

        $career = Job::findOrFail($career_id);

        // Buat plusValue baru
        $plusValue = new JobPlusValue();
        $plusValue->name = $request->input('plusvalue_name');

        $career->skillRequirements()->save($plusValue);
        addRec('Plus Value', Auth::id(), Auth::user()->role_id, $plusValue->name);

        return redirect()->route('career-edit', $career->id)->with('success', 'Plus value has been added successfully.');
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
