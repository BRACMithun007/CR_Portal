<?php

namespace App\Http\Controllers;

use App\changeRequestMaster;
use App\Libraries\aclHandler;
use App\RequestCR;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class reqMfCrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (aclHandler::hasModuleAccess(['req_cr_read','req_cr_write']) == false){
            die('No access !');
        }

        return view('request-cr.request-cr-list');
    }

    public function getMfRequestCrList(Request $request)
    {
        $data = RequestCR::where('is_archived', 0)->orderBy('created_at', 'ASC')->get();

        return Datatables::of(collect($data))
            ->editColumn('cr_title', function ($data) {
                $formation = (strlen($data->cr_title) >40) ? ' ....':'';
                return substr($data->cr_title, 0, 40) . $formation;
            })->addColumn('action', function ($data) {
                $action = '';
                if(Auth::user()->type == 'SuperAdmin') {
                    $action = ' <button type="button" class="btn btn-xs btn-danger delete_req_cr" data-cr_id="' . $data->id . '"><b><i class="fa fa-trash"></i> Delete</b></button> &nbsp;';
                }
                if (aclHandler::hasActionAccess('mf_cr_write') == true) {
                    if($data->cr_status == 'Submitted'){
                        $action .= '<button type="button" class="btn btn-xs btn-info open_req_cr_import_modal" data-cr_id="' . $data->id . '" ><b><i class="fa fa-edit"></i>CR Import</b></button>&nbsp';
                        $action .= '<button type="button" class="btn btn-xs btn-info open_req_cr_edit_modal" data-cr_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> CR Edit</b></button>';
                    }
                }
                return $action;
            })->editColumn('jira_code', function ($data) {
                return '<a href="https://tim.brac.net/browse/'.$data->jira_code.'" target="_blank" style="color:#EC008C;">'.$data->jira_code.'</a>';
            })->editColumn('downloads', function ($data) {
                $docBtn = '';
                if(isset($data->cr_doc_link) && $data->cr_doc_link != ''){
                    $docBtn .= '<a class="btn btn-xs" href="'.url('final_cr_doc/'.$data->cr_doc_link).'" style="background-color:#009A93;color:white;" target="_blank">CR</a>';
                }
                return $docBtn;
            })->editColumn('updated_at', function ($data) {
                return $update_was = Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->diffForHumans();
            })
            ->removeColumn('id')
            ->rawColumns(['action','jira_code','downloads'])
            ->make(true);
    }


    public function requestStore(Request $request)
    {
//        if (aclHandler::hasActionAccess('mf_cr_write') == false) {
//            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
//        }

        $rules = [
            'cr_title'       => 'required',
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required fields']);
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

        $data = array(
            'cr_title'       => $cr_title,
            'cr_doc_link'    => $cr_doc_name,
            'category'       => $category,
            'vendor_name'    => $vendor_name,
            'cr_details'     => $cr_details,
            'team_name'      => $team_name,
            'requester_team' => $requester_team,
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
        if(isset($mf_expect_timeline) && $mf_expect_timeline != null){
            $data['mf_expect_timeline'] = date("Y-m-d", strtotime($mf_expect_timeline));
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
            RequestCR::create($data);
            DB::commit();

            return response()->json( ['responseCode'=>1,'message'=>'Successfully created']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }
    }


    public function getReqCRInfo(Request $request)
    {
        $rules = [
            'cr_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $cr_id = trim($request->get('cr_id'));
        $crData = RequestCR::where('id',$cr_id)->first();

        $public_html = strval(view("request-cr.req-cr-mf-info-update-modal", compact('crData')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);
    }


    public function updateReqCRInfo(Request $request)
    {


        $cr_title = trim($request->get('cr_title'));
        $cr_doc = $request->file('cr_doc');
        $cr_doc_name = '';
        if ( $cr_doc ) {
            $replacedSubStr = substr(str_replace(" ","-",$cr_title), 0, 10);
            $cr_doc_name = $replacedSubStr.date('mdhis').rand(11,99) . '.' . $cr_doc->getClientOriginalExtension();
            $cr_doc->move(public_path('final_cr_doc'), $cr_doc_name);
        }

        $category = trim($request->get('category'));
        $cr_details = $request->get('cr_details');
        $team_name = $request->get('team_name');
        $mf_expect_timeline = $request->get('mf_expect_timeline');
        $cr_id = $request->get('cr_id');

        $data = array(
            'cr_title'       => $cr_title,
            'cr_doc_link'    => $cr_doc_name,
            'category'       => $category,
            'cr_details'     => $cr_details,
            'team_name'      => $team_name,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        );
        if(isset($jira_code) && $jira_code != null){$data['jira_code'] = $jira_code;}
        if(isset($mf_expect_timeline) && $mf_expect_timeline != null){
            $data['mf_expect_timeline'] = date("Y-m-d", strtotime($mf_expect_timeline));
        }

        try {

        DB::beginTransaction();
            RequestCR::where('id',$cr_id)->update($data);
        DB::commit();

        return response()->json( ['responseCode'=>1,'message'=>'Successfully updated']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }
    }


    public function getReqCRImportInfo(Request $request)
    {
        $rules = [
            'cr_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $cr_id = trim($request->get('cr_id'));
        $crData = RequestCR::where('id',$cr_id)->first();

        $public_html = strval(view("request-cr.req-cr-mf-import-modal", compact('crData')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);
    }

    public function importReqStore(Request $request)
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
            'cr_type'        => 'required',
            'req_cr_id'        => 'required',
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
        $req_cr_id = $request->get('req_cr_id');

        $data = array(
            'cr_title'       => $cr_title,
            'cr_doc_link'    => $cr_doc_name,
            'category'       => $category,
            'vendor_name'    => $vendor_name,
            'cr_details'     => $cr_details,
            'team_name'      => $team_name,
            'requester_team' => $requester_team,
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
        if(isset($mf_expect_timeline) && $mf_expect_timeline != null){
            $data['mf_expect_timeline'] = date("Y-m-d", strtotime($mf_expect_timeline));
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
            changeRequestMaster::create($data);
            RequestCR::where('id',$req_cr_id)->update([
                'cr_status' => 'Imported'
            ]);
            DB::commit();

            return response()->json( ['responseCode'=>1,'message'=>'Successfully created']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }
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
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
