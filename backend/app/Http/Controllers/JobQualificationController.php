<?php

namespace App\Http\Controllers;

use App\Models\CareerPages;
use App\Models\Job;
use App\Models\JobPlusValue;
use App\Models\JobQualification;
use App\Models\SkillRequirement;
use Google\Cloud\Talent\V4\JobQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobQualificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getJobQualification()
    {
        $careers = Job::all();
        $JobQualifications = JobQualification::all();
        return view('cms.Career.JobQualification.jobqualification', compact('JobQualifications', 'careers'));        //
    }


    public function showJobQualification()
    {
        return view('cms.Career.career', compact('JobQualifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addJobQualification()
    {
        return view('cms.Career.JobQualification.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeJobQualification(Request $request)
    {
        try{
        $validateData = $request->validate([
            'gender' => 'required',
            'domicile' => 'required',
            'education' => 'required',
            'major' => 'required',
            'other' => 'required',
        ]);

        $Quali = JobQualification::create($validateData);
        addRec('Job Qualification', Auth::id(), Auth::user()->role_id, ("Job Qualification ". $Quali->id));
        return redirect()->route('career')->with('success', 'Job Qualification added successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateJobQualification(Request $request, $id)
    {
        try{
        $jobQualification = JobQualification::find($id);
        $jobQualiBefore = clone $jobQualification;
        $data = $request->only(['gender', 'domicile', 'education', 'major', 'other']);

        $jobQualification->update($data);
        editRec('job Qualification', Auth::id(), Auth::user()->role_id, $jobQualiBefore, $jobQualification, ("Job Qualification " . $jobQualification->id));
        return redirect()->route('career')->with('success', 'Job Qualification updated successfully.');
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
    public function deleteJobQualification($id)
    {
        try{
        $JobQualifications = JobQualification::find($id);

        if (!$JobQualifications) {
            return redirect()->route('career')->with('error', 'Item not found.');
        }


        $jobs = Job::where('jobs_qualification_id', $id)->get();
        return $id;

        foreach ($jobs as $job) {
            // Delete related records
            JobPlusValue::where('jobs_id', $job->id)->delete();
            SkillRequirement::where('jobs_id', $job->id)->delete();

            // Delete the job
            $job->delete();
            deleteRec('Career of Job Qualification', Auth::id(), Auth::user()->role_id, $job->name_position);
        }

        $JobQualifications->delete();
        deleteRec("Job Qualifications", Auth::id(), Auth::user()->role_id, ("Job Qualification ". $JobQualifications->id));
        return redirect()->route('career.get-jobQualification')->with('success', 'Item has been deleted.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
