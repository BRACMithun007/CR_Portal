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
            ->get([
                DB::raw("COUNT(CASE WHEN cr_type = 'Core_Business' AND DATE_FORMAT(completed_on, '%b') = 'Jan' THEN 1 END) AS Core_Business_jan"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Core_Business' AND DATE_FORMAT(completed_on, '%b') = 'Feb' THEN 1 END) AS Core_Business_feb"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Core_Business' AND DATE_FORMAT(completed_on, '%b') = 'Mar' THEN 1 END) AS Core_Business_mar"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Core_Business' AND DATE_FORMAT(completed_on, '%b') = 'Apr' THEN 1 END) AS Core_Business_apr"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Core_Business' AND DATE_FORMAT(completed_on, '%b') = 'May' THEN 1 END) AS Core_Business_may"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Core_Business' AND DATE_FORMAT(completed_on, '%b') = 'Jun' THEN 1 END) AS Core_Business_jun"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Core_Business' AND DATE_FORMAT(completed_on, '%b') = 'Jul' THEN 1 END) AS Core_Business_jul"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Core_Business' AND DATE_FORMAT(completed_on, '%b') = 'Aug' THEN 1 END) AS Core_Business_aug"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Core_Business' AND DATE_FORMAT(completed_on, '%b') = 'Sep' THEN 1 END) AS Core_Business_sep"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Core_Business' AND DATE_FORMAT(completed_on, '%b') = 'Oct' THEN 1 END) AS Core_Business_oct"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Core_Business' AND DATE_FORMAT(completed_on, '%b') = 'Nov' THEN 1 END) AS Core_Business_nov"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Core_Business' AND DATE_FORMAT(completed_on, '%b') = 'Dec' THEN 1 END) AS Core_Business_dec"),

                DB::raw("COUNT(CASE WHEN cr_type = 'Support_CR' AND DATE_FORMAT(completed_on, '%b') = 'Jan' THEN 1 END) AS Support_CR_jan"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Support_CR' AND DATE_FORMAT(completed_on, '%b') = 'Feb' THEN 1 END) AS Support_CR_feb"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Support_CR' AND DATE_FORMAT(completed_on, '%b') = 'Mar' THEN 1 END) AS Support_CR_mar"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Support_CR' AND DATE_FORMAT(completed_on, '%b') = 'Apr' THEN 1 END) AS Support_CR_apr"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Support_CR' AND DATE_FORMAT(completed_on, '%b') = 'May' THEN 1 END) AS Support_CR_may"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Support_CR' AND DATE_FORMAT(completed_on, '%b') = 'Jun' THEN 1 END) AS Support_CR_jun"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Support_CR' AND DATE_FORMAT(completed_on, '%b') = 'Jul' THEN 1 END) AS Support_CR_jul"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Support_CR' AND DATE_FORMAT(completed_on, '%b') = 'Aug' THEN 1 END) AS Support_CR_aug"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Support_CR' AND DATE_FORMAT(completed_on, '%b') = 'Sep' THEN 1 END) AS Support_CR_sep"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Support_CR' AND DATE_FORMAT(completed_on, '%b') = 'Oct' THEN 1 END) AS Support_CR_oct"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Support_CR' AND DATE_FORMAT(completed_on, '%b') = 'Nov' THEN 1 END) AS Support_CR_nov"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Support_CR' AND DATE_FORMAT(completed_on, '%b') = 'Dec' THEN 1 END) AS Support_CR_dec"),

                DB::raw("COUNT(CASE WHEN cr_type = 'Configurable' AND DATE_FORMAT(completed_on, '%b') = 'Jan' THEN 1 END) AS Configurable_jan"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Configurable' AND DATE_FORMAT(completed_on, '%b') = 'Feb' THEN 1 END) AS Configurable_feb"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Configurable' AND DATE_FORMAT(completed_on, '%b') = 'Mar' THEN 1 END) AS Configurable_mar"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Configurable' AND DATE_FORMAT(completed_on, '%b') = 'Apr' THEN 1 END) AS Configurable_apr"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Configurable' AND DATE_FORMAT(completed_on, '%b') = 'May' THEN 1 END) AS Configurable_may"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Configurable' AND DATE_FORMAT(completed_on, '%b') = 'Jun' THEN 1 END) AS Configurable_jun"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Configurable' AND DATE_FORMAT(completed_on, '%b') = 'Jul' THEN 1 END) AS Configurable_jul"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Configurable' AND DATE_FORMAT(completed_on, '%b') = 'Aug' THEN 1 END) AS Configurable_aug"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Configurable' AND DATE_FORMAT(completed_on, '%b') = 'Sep' THEN 1 END) AS Configurable_sep"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Configurable' AND DATE_FORMAT(completed_on, '%b') = 'Oct' THEN 1 END) AS Configurable_oct"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Configurable' AND DATE_FORMAT(completed_on, '%b') = 'Nov' THEN 1 END) AS Configurable_nov"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Configurable' AND DATE_FORMAT(completed_on, '%b') = 'Dec' THEN 1 END) AS Configurable_dec"),

                DB::raw("COUNT(CASE WHEN cr_type = 'Integration' AND DATE_FORMAT(completed_on, '%b') = 'Jan' THEN 1 END) AS Integration_jan"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Integration' AND DATE_FORMAT(completed_on, '%b') = 'Feb' THEN 1 END) AS Integration_feb"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Integration' AND DATE_FORMAT(completed_on, '%b') = 'Mar' THEN 1 END) AS Integration_mar"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Integration' AND DATE_FORMAT(completed_on, '%b') = 'Apr' THEN 1 END) AS Integration_apr"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Integration' AND DATE_FORMAT(completed_on, '%b') = 'May' THEN 1 END) AS Integration_may"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Integration' AND DATE_FORMAT(completed_on, '%b') = 'Jun' THEN 1 END) AS Integration_jun"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Integration' AND DATE_FORMAT(completed_on, '%b') = 'Jul' THEN 1 END) AS Integration_jul"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Integration' AND DATE_FORMAT(completed_on, '%b') = 'Aug' THEN 1 END) AS Integration_aug"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Integration' AND DATE_FORMAT(completed_on, '%b') = 'Sep' THEN 1 END) AS Integration_sep"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Integration' AND DATE_FORMAT(completed_on, '%b') = 'Oct' THEN 1 END) AS Integration_oct"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Integration' AND DATE_FORMAT(completed_on, '%b') = 'Nov' THEN 1 END) AS Integration_nov"),
                DB::raw("COUNT(CASE WHEN cr_type = 'Integration' AND DATE_FORMAT(completed_on, '%b') = 'Dec' THEN 1 END) AS Integration_dec"),
            ])->toArray();

            $monthWiseCrCompletion = $crCompletionCount[0];

            $public_html = strval(view("dashboard.cr_area_chart",compact('monthWiseCrCompletion')));

            return response()->json( ['responseCode'=>1,'html'=>$public_html]);

//        } catch (\Exception $e) {
//            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
//        }
    }


}
