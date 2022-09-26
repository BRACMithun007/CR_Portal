<?php

namespace App\Http\Controllers;

use App\Career;
use App\CareerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CareerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function internship()
    {
        $careerData = Career::where('status',1)->where('job_type','Internship')
            ->orderBy('id', 'DESC')->get();
        return view('career_job_list',compact('careerData'));
    }

    public function fullTimeJobs()
    {
        $careerData = Career::where('status',1)->where('job_type','Full Time jobs')
            ->orderBy('id', 'DESC')->get();
        return view('career_job_list',compact('careerData'));
    }

    public function partTimeJobs()
    {
        $careerData = Career::where('status',1)->where('job_type','Part Time Jobs')
            ->orderBy('id', 'DESC')->get();
        return view('career_job_list',compact('careerData'));
    }

    public function fullTimeResearchers()
    {
        $careerData = Career::where('status',1)->where('job_type','Full TIme Researchers')
            ->orderBy('id', 'DESC')->get();
        return view('career_job_list',compact('careerData'));
    }

    public function partTimeResearchers()
    {
        $careerData = Career::where('status',1)->where('job_type','Part TIme Researchers')
            ->orderBy('id', 'DESC')->get();
        return view('career_job_list',compact('careerData'));
    }

    public function applyNow($id)
    {
        $careerData = Career::where('id',$id)->where('status',1)->first();
        if($careerData == null){die('Invalid request');}

        return view('career_apply_now',compact('careerData'));
    }

    public function submitApplication(Request $request)
    {

        $rules = [
            'job_tracking_id'  => 'required',
            'first_name'  => 'required',
            'last_name'    => 'required',
            'email'   => 'required|email',
            'cv_attachment'   => 'required|mimes:pdf'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            Session::flash('error', "Please fill up all field with valid data");
            return redirect()->back();
        }

        $job_tracking_id = trim($request->get('job_tracking_id'));
        $first_name = trim($request->get('first_name'));
        $last_name = trim($request->get('last_name'));
        $email = trim($request->get('email'));
        $cv_attachment = $request->get('cv_attachment');
        $file = $request->file('cv_attachment');

        $careerData = Career::where('id',$job_tracking_id)->where('status',1)->first();
        if($careerData == null){
            Session::flash('error', "Invalid request");
            return redirect()->back();
        }
        $applyData = CareerApplication::where('career_id',$job_tracking_id)->where('email',$email)->count();
        if($applyData > 0){
            Session::flash('error', "Sorry !! you already applied");
            return redirect()->back();
        }

        try {

            $md5Name = md5_file($request->file('cv_attachment')->getRealPath());
            $guessExtension = $request->file('cv_attachment')->guessExtension();
            $microtime = microtime();
            $microtime = str_replace('.','',$microtime);
            $file_name = str_replace(' ','',$microtime.$md5Name.'.'.$guessExtension);
            $file->move(public_path('/cv_attachment'), $file_name);

            DB::beginTransaction();
            $CareerApplication = new CareerApplication();
            $CareerApplication->career_id = $careerData->id;
            $CareerApplication->job_type = $careerData->job_type;
            $CareerApplication->first_name = $first_name;
            $CareerApplication->last_name = $last_name;
            $CareerApplication->email = $email;
            $CareerApplication->cv_attachment = $file_name;
            $CareerApplication->save();

            DB::commit();

            Session::flash('success', "Successfully submitted");
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', "Could not submit application");
            return redirect()->back();
        }

    }
}
