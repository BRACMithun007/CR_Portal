<?php

namespace App\Http\Controllers;

use App\changeRequestMaster;
use App\circularMaster;
use Carbon\Carbon;
use App\Libraries\aclHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class MfCircularController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (aclHandler::hasModuleAccess(['circular_read','circular_write']) == false){
            die('No access !');
        }

        return view('mf_circular.mf-circular-list');
    }


    public function getMfCircularList(Request $request)
    {
        $loan = trim($request->get('loan'));
        $general_savings = trim($request->get('general_savings'));
        $special_savings = trim($request->get('special_savings'));
        $insurance = trim($request->get('insurance'));

        $data = circularMaster::where('is_archived', 0)
            ->where(function ($query) use ($loan,$general_savings,$special_savings,$insurance){
                if ($loan == "true") {$query->orWhere('category', 'loan');}
                if ($general_savings == "true") {$query->orWhere('category', 'general_savings');}
                if ($special_savings  == "true") {$query->orWhere('category', 'special_savings');}
                if ($insurance  == "true") {$query->orWhere('category', 'insurance');}
            })->orderBy('created_at', 'ASC')->get();


        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '';
                if(Auth::user()->type == 'SuperAdmin') {
                    $action = ' <button type="button" class="btn btn-xs btn-danger delete_circular" data-circular_id="' . $data->id . '"><b><i class="fa fa-trash"></i> Delete</b></button> &nbsp;';
                }
                if(Auth::user()->id == $data->created_by && $data->status == 'Submitted') {
                    $action .= '<button type="button" class="btn btn-xs open_circular_modal" style="background-color:#009A93;color:white;" data-circular_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> Edit</b></button> &nbsp;';
                }
                if ($data->status == 'Submitted' && aclHandler::hasActionAccess('mf_cr_write') == true) {
                    $action .= '<button type="button" class="btn btn-xs btn-success open_circular_import_modal" data-circular_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> Import </b></button>';
                }
                return $action;
            })->editColumn('downloads', function ($data) {
                $docBtn = '';
                if(isset($data->circular_doc) && $data->circular_doc != ''){
                    $docBtn .= '<a class="btn btn-xs" href="'.url('circular_doc/'.$data->circular_doc).'" style="background-color:#009A93;color:white;" target="_blank">Circular</a>';
                }
                return $docBtn;
            })->editColumn('updated_at', function ($data) {
                return  Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->diffForHumans();
            })->editColumn('mf_expect_timeline', function ($data) {
                if($data->mf_expect_timeline != null && $data->mf_expect_timeline != '' && $data->mf_expect_timeline != '0000-00-00')
                    return Carbon::parse($data->mf_expect_timeline)->format('d M Y');
                else
                    return 'Not set';

            })
            ->removeColumn('id')
            ->rawColumns(['action','downloads'])
            ->make(true);
    }


    public function addCircularTemplate(Request $request)
    {
        $rules = [
            'category'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $category = $request->get('category');

        switch ($category) {
            case "loan":
                $public_html = strval(view("mf_circular.add-loan-template"));
                break;
            case "general_savings":
                $public_html = strval(view("mf_circular.add-general-savings-template"));
                break;
            case "special_savings":
                $public_html = strval(view("mf_circular.add-special-savings-template"));
                break;
            case "insurance":
                $public_html = strval(view("mf_circular.add-insurance-template"));
                break;
            default:
                $public_html = 'Not valid request';
        }

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addNewCircular(Request $request)
    {
        if (aclHandler::hasActionAccess('circular_write') == false) {
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'circular_doc'        => 'required|mimes:pdf',
            'circular_category'   => 'required',
            'circular_title'      => 'required',
            'circular_details'    => 'required',
            'circular_number'     => 'required',
            'requester_team'      => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required fields']);
        }

        $circular_doc = $request->file('circular_doc');
        $circular_title = trim($request->get('circular_title'));
        $circular_details = $request->get('circular_details');
        $circular_category = trim($request->get('circular_category'));
        $mf_expect_timeline = $request->get('mf_expect_timeline');

        $circular_number = $request->get('circular_number');
        $requester_team = $request->get('requester_team');
        $sign_date = $request->get('sign_date');
        $circular_type = $request->get('circular_type');
        $jira_code = $request->get('jira_code');
        $effective_date = $request->get('effective_date');

        if(isset($jira_code) && $jira_code != null && $jira_code != ""){
            $checkDuplicate = changeRequestMaster::where('jira_code','=',$jira_code)->count();
            if ( $checkDuplicate > 0 ) {
                return response()->json( ['responseCode'=>0,'message'=>'Jira code already exists']);
            }
        }

        $replacedSubStr = substr(str_replace(" ","-",$circular_title), 0, 10);
        $circular_doc_name = $replacedSubStr.date('mdhis').rand(11,99) . '.' . $circular_doc->getClientOriginalExtension();
        $circular_doc->move(public_path('circular_doc'), $circular_doc_name);

        $data = array(
            'title'         => $circular_title,
            'details'       => $circular_details,
            'category'      => $circular_category,
            'circular_doc'  => $circular_doc_name,
            'request_on'  => date('Y-m-d'),
            'circular_number'  => $circular_number,
            'requester_team'  => $requester_team,
            'status'  => 'Submitted',
            'request_by' => Auth::user()->name,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        );

        if(isset($mf_expect_timeline) && $mf_expect_timeline != null){
            $data['mf_expect_timeline'] = date("Y-m-d", strtotime($mf_expect_timeline));
        }
        if(isset($sign_date) && $sign_date != null){
            $data['sign_date'] = date("Y-m-d", strtotime($sign_date));
        }
        if(isset($effective_date) && $effective_date != null){
            $data['effective_date'] = date("Y-m-d", strtotime($effective_date));
        }
        if(isset($circular_type) && $circular_type != null){
            $data['circular_type'] = $circular_type;
        }
        if(isset($jira_code) && $jira_code != null){
            $data['jira_code'] = $jira_code;
        }

        try {

            DB::beginTransaction();
            circularMaster::create($data);
            DB::commit();

            return response()->json( ['responseCode'=>1,'message'=>'Successfully created']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }
    }


    public function getCircularInfo(Request $request)
    {
        if (aclHandler::hasActionAccess('circular_read') == false) {
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'circular_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $circular_id = trim($request->get('circular_id'));
        $circularData = circularMaster::where('id',$circular_id)->first();

        $public_html = strval(view("mf_circular.mf-circular-update-modal", compact('circularData')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);
    }


    public function getCircularImportableInfo(Request $request)
    {
        if (aclHandler::hasActionAccess('mf_cr_write') == false) {
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'circular_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $circular_id = trim($request->get('circular_id'));
        $circularData = circularMaster::where('id',$circular_id)->first();

        $public_html = strval(view("mf_circular.circular-import-modal", compact('circularData')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);
    }


    public function importCircular(Request $request)
    {
        if (aclHandler::hasActionAccess('mf_cr_write') == false) {
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'cr_title'       => 'required',
            'category'       => 'required',
            'vendor_name'    => 'required',
            'cr_details'     => 'required',
            'team_name'      => 'required',
            'requester_team' => 'required',
            'mf_expect_timeline' => 'required',
            'cr_type'        => 'required',
            'circular_id'        => 'required',
            'assigned_from_brac' => 'required'
        ];


        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required fields']);
        }

        $jira_code = trim($request->get('jira_code'));
        if(isset($jira_code) && $jira_code != null && $jira_code != ""){
            $checkDuplicate = changeRequestMaster::where('jira_code','=',$jira_code)->count();
            if ( $checkDuplicate > 0 ) {
                return response()->json( ['responseCode'=>0,'message'=>'Jira already created']);
            }
        }

        $cr_title = trim($request->get('cr_title'));
        $cr_doc = $request->file('cr_doc');
        $cr_doc_name = '';
        if ( $cr_doc ) {
            $replacedSubStr = substr(str_replace(" ","-",$cr_title), 0, 10);
            $cr_doc_name = $replacedSubStr.date('mdhis').rand(11,99) . '.' . $cr_doc->getClientOriginalExtension();
            $cr_doc->move(public_path('final_cr_doc'), $cr_doc_name);
        }

        $approved_billable_effort = $request->get('approved_billable_effort');
        $category = trim($request->get('category'));
        $vendor_name = trim($request->get('vendor_name'));
        $vendor_proposed_timeline = $request->get('vendor_proposed_timeline');
        $priority = $request->get('priority');
        $cr_status = $request->get('cr_status');
        $business_analyst = $request->get('business_analyst');
        $uat_instance = $request->get('uat_instance');
        $cr_details = $request->get('cr_details');
        $initial_requirement_shared_from_mf = $request->get('initial_requirement_shared_from_mf');
        $team_name = $request->get('team_name');
        $cr_locked_by_vendor = $request->get('cr_locked_by_vendor');
        $mf_expect_timeline = $request->get('mf_expect_timeline');
        $requester_team = $request->get('requester_team');
        $cr_type = $request->get('cr_type');
        $completed_on = $request->get('completed_on');
        $assigned_from_brac = $request->get('assigned_from_brac');
        $uat_credential = $request->get('uat_credential');
        $satisfactory_level = $request->get('satisfactory_level');
        $jira_created = $request->get('jira_created');
        $circular_id = trim($request->get('circular_id'));


        $circularData = circularMaster::where('id',$circular_id)->first();
        if ( !isset($circularData->id) ) {
            return response()->json( ['responseCode'=>0,'message'=>'Circular not found']);
        }elseif ( $circularData->status != 'Submitted' ) {
            return response()->json( ['responseCode'=>0,'message'=>'Circular already imported']);
        }

        $data = array(
            'cr_title'       => $cr_title,
            'cr_doc_link'    => $cr_doc_name,
            'circular_doc'   => $circularData->circular_doc,
            'category'       => $category,
            'vendor_name'    => $vendor_name,
            'cr_details'     => $cr_details,
            'team_name'      => $team_name,
            'requester_team' => $requester_team,
            'mf_expect_timeline' => date("Y-m-d", strtotime($mf_expect_timeline)),
            'cr_type'        => $cr_type,
            'assigned_from_brac' => $assigned_from_brac,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        );
        if(isset($jira_code) && $jira_code != null){$data['jira_code'] = $jira_code;}
        if(isset($approved_billable_effort) && $approved_billable_effort != null){$data['approved_billable_effort'] = $approved_billable_effort;}
        if(isset($vendor_proposed_timeline) && $vendor_proposed_timeline != null){
            $data['vendor_proposed_timeline'] = date("Y-m-d", strtotime($vendor_proposed_timeline));
        }
        if(isset($priority) && $priority != null){$data['priority'] = $priority;}
        if(isset($cr_status) && $cr_status != null){$data['cr_status'] = $cr_status;}
        if(isset($business_analyst) && $business_analyst != null){$data['business_analyst'] = $business_analyst;}
        if(isset($uat_instance) && $uat_instance != null){$data['uat_instance'] = $uat_instance;}
        if(isset($initial_requirement_shared_from_mf) && $initial_requirement_shared_from_mf != null){
            $data['initial_requirement_shared_from_mf'] = date("Y-m-d", strtotime($initial_requirement_shared_from_mf));
        }
        if(isset($cr_locked_by_vendor) && $cr_locked_by_vendor != null){
            $data['cr_locked_by_vendor'] = date("Y-m-d", strtotime($cr_locked_by_vendor));
        }
        if(isset($jira_created) && $jira_created != null){
            $data['jira_created'] = date("Y-m-d", strtotime($jira_created));
        }
        if(isset($completed_on) && $completed_on != null){
            $data['completed_on'] = date("Y-m-d", strtotime($completed_on));
        }
        if(isset($uat_credential) && $uat_credential != null){$data['uat_credential'] = $uat_credential;}
        if(isset($satisfactory_level) && $satisfactory_level != null){$data['satisfactory_level'] = $satisfactory_level;}

        try {

            DB::beginTransaction();
            $crMaster = changeRequestMaster::create($data);

            circularMaster::where('id',$circular_id)->update([
                'cr_master_id'=>$crMaster->id,
                'status'=>$cr_status,
                'status_changed_by_id'=>Auth::user()->id,
                'status_changed_by_name'=>Auth::user()->name
            ]);
            DB::commit();

            return response()->json( ['responseCode'=>1,'message'=>'Successfully created']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }
    }


    public function updateCircularInfo(Request $request)
    {
        if (aclHandler::hasActionAccess('circular_write') == false) {
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'circular_id'         => 'required',
            'circular_category'   => 'required',
            'circular_title'      => 'required',
            'circular_details'    => 'required',
            'circular_number'     => 'required',
            'requester_team'      => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required fields']);
        }


        $circular_id = trim($request->get('circular_id'));
        $circular_title = trim($request->get('circular_title'));
        $circular_details = $request->get('circular_details');
        $circular_category = trim($request->get('circular_category'));
        $mf_expect_timeline = $request->get('mf_expect_timeline');

        $circular_number = $request->get('circular_number');
        $requester_team = $request->get('requester_team');
        $sign_date = $request->get('sign_date');
        $circular_type = $request->get('circular_type');
        $jira_code = $request->get('jira_code');
        $effective_date = $request->get('effective_date');

        if(isset($jira_code) && $jira_code != null && $jira_code != ""){
            $checkDuplicate = changeRequestMaster::where('jira_code','=',$jira_code)->count();
            if ( $checkDuplicate > 0 ) {
                return response()->json( ['responseCode'=>0,'message'=>'Jira code already exists']);
            }
        }

        $circular_doc = $request->file('circular_doc');
        $circular_doc_name = '';

        if ( $request->hasFile('circular_doc') ) {
            $replacedSubStr = substr(str_replace(" ","-",$circular_title), 0, 10);
            $circular_doc_name = $replacedSubStr.date('mdhis').rand(11,99) . '.' . $circular_doc->getClientOriginalExtension();
            $circular_doc->move(public_path('circular_doc'), $circular_doc_name);
        }

        $data = array(
            'title'         => $circular_title,
            'details'       => $circular_details,
            'category'      => $circular_category,
            'request_on'  => date('Y-m-d'),
            'circular_number'  => $circular_number,
            'requester_team'  => $requester_team,
            'status'  => 'Submitted',
            'request_by' => Auth::user()->name,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        );

        if(isset($mf_expect_timeline) && $mf_expect_timeline != null){
            $data['mf_expect_timeline'] = date("Y-m-d", strtotime($mf_expect_timeline));
        }
        if(isset($sign_date) && $sign_date != null){
            $data['sign_date'] = date("Y-m-d", strtotime($sign_date));
        }
        if(isset($effective_date) && $effective_date != null){
            $data['effective_date'] = date("Y-m-d", strtotime($effective_date));
        }
        if(isset($circular_type) && $circular_type != null){
            $data['circular_type'] = $circular_type;
        }
        if(isset($jira_code) && $jira_code != null){
            $data['jira_code'] = $jira_code;
        }
        if( $circular_doc_name != ''){
            $data['circular_doc'] = $circular_doc_name;
        }

        try {

            DB::beginTransaction();
            circularMaster::where('id',$circular_id)->update($data);
            DB::commit();

            return response()->json( ['responseCode'=>1,'message'=>'Successfully updated']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (aclHandler::hasActionAccess('circular_write') == false) {
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'circular_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        circularMaster::where('id',$request->get('circular_id'))->delete();

        return response()->json( ['responseCode'=>1,'message'=>'Successfully deleted']);

    }
}
