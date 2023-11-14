<?php

namespace App\Http\Controllers;

use App\Models\CareerPages;
use App\Models\Job;
use App\Models\JobPlusValue;
use App\Models\JobQualification;
use App\Models\SkillRequirement;
use Google\Cloud\Talent\V4\JobQuery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        $validateData = $request->validate([
            'gender' => 'required',
            'domicile' => 'required',
            'education' => 'required',
            'major' => 'required',
            'other' => 'required',
        ]);

        $qualification = JobQualification::create($validateData);

        addRec('Job Qualification', Auth::id(), Auth::user()->role_id, 'Job Qualification ID: ' . $qualification->id);

        return redirect()->route('career')->with('success', 'Job Qualification added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editJobQualification($id)
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
    public function updateJobQualification(Request $request, $id)
    {
        $jobQualification = JobQualification::find($id);

        $data = $request->only(['gender', 'domicile', 'education', 'major', 'other']);

        $qualification= $jobQualification->update($data);
        editRec('Qualification', Auth::id(), Auth::user()->role_id, $qualification->id, $qualification);



        return redirect()->route('career')
            ->with('success', 'Job Qualification updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteJobQualification($id)
    {
        $JobQualifications = JobQualification::find($id);

        if (!$JobQualifications) {
            return redirect()->route('career')->with('error', 'Item not found.');
        }


        $jobs = Job::where('jobs_qualification_id', $id)->get();

        foreach ($jobs as $job) {
            // Delete related records
            $jobPlusValue = JobPlusValue::where('jobs_id', $job->id)->delete();
            $SkillRequirement = SkillRequirement::where('jobs_id', $job->id)->delete();

            // Delete the job
            $job->delete();
            deleteRec('Job', Auth::id(), Auth::user()->role_id, $jobPlusValue, $SkillRequirement);

        }

        // $jobs = Job::where('jobs_qualification_id', $id);
        // foreach($jobs as $job){
            //     JobPlusValue::where('jobs_id', $job->id)->delete();
            //     SkillRequirement::where('jobs_id', $job->id)->delete();
            //     echo 'ini'.$job->id;
            //     // $job->delete();

            $JobQualifications->delete();
            deleteRec('Job Qualification', Auth::id(), Auth::user()->role_id, $jobPlusValue, $SkillRequirement);

        return redirect()->route('career')->with('success', 'Item has been deleted.');
    }
}
