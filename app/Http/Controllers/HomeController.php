<?php

namespace App\Http\Controllers;

use App\changeRequestMaster;
use App\changeRequestUpdates;
use App\Libraries\aclHandler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ongoingCR = changeRequestMaster::where('cr_status', 'Ongoing')->count();
        return view('dashboard',compact('ongoingCR'));
    }

    public function crStatusChart(Request $request)
    {
//        if (aclHandler::hasActionAccess('mf_cr_write') == false) {
//            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
//        }

        try {
            $crStatus = changeRequestMaster::where('is_archived', '=', 0)
                ->get([
                    DB::raw("COUNT(CASE WHEN cr_status = 'Ongoing' THEN 1 END) AS Ongoing"),
                    DB::raw("COUNT(CASE WHEN cr_status = 'Backlog' THEN 1 END) AS Backlog"),
                    DB::raw("COUNT(CASE WHEN cr_status = 'Deployed' THEN 1 END) AS Deployed"),
                    DB::raw("COUNT(CASE WHEN cr_status = 'Halt' THEN 1 END) AS Halt"),
                ])->toArray();

            $statusValArray["Ongoing"] = $crStatus[0]['Ongoing'];
            $statusValArray["Backlog"] = $crStatus[0]['Backlog'];
            $statusValArray["Deployed"] = $crStatus[0]['Deployed'];
            $statusValArray["Halt"] = $crStatus[0]['Halt'];

            $public_html = strval(view("dashboard.cr_status_chart",compact('statusValArray')));

            return response()->json( ['responseCode'=>1,'html'=>$public_html]);

        } catch (\Exception $e) {
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }
    }

    public function crAreaChart(Request $request)
    {
//        if (aclHandler::hasActionAccess('mf_cr_write') == false) {
//            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
//        }

      //  try {
            $crCompletionCount = changeRequestMaster::where('is_archived', '=', 0)->where('cr_status', '=', 'Deployed')
                ->where('completed_on', '!=', null)
                ->where( DB::raw('YEAR(completed_on)'), '=', date("Y") )
                ->where('completed_on', '!=', '')
                ->groupBy('completionMonth')
                ->get([
                    'completed_on',
                    DB::raw("COUNT(id) AS completedNumber"),
                    DB::raw("MONTH(completed_on) As completionMonth"),
                ])->toArray();

            $crCompletionArray["Jan"] = 0;
            $crCompletionArray["Feb"] = 0;
            $crCompletionArray["Mar"] = 0;
            $crCompletionArray["Apr"] = 0;
            $crCompletionArray["May"] = 0;
            $crCompletionArray["Jun"] = 0;
            $crCompletionArray["Jul"] = 0;
            $crCompletionArray["Aug"] = 0;
            $crCompletionArray["Sep"] = 0;
            $crCompletionArray["Oct"] = 0;
            $crCompletionArray["Nov"] = 0;
            $crCompletionArray["Dec"] = 0;

            foreach ($crCompletionCount as $data){
                $crCompletionArray[date('M',strtotime($data['completed_on']))] = $data['completedNumber'];
            }

        $public_html = strval(view("dashboard.cr_area_chart",compact('crCompletionArray')));

            return response()->json( ['responseCode'=>1,'html'=>$public_html]);

//        } catch (\Exception $e) {
//            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
//        }
    }


}
