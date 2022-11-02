<?php

namespace App\Http\Controllers;

use App\changeRequestComments;
use App\changeRequestMaster;
use App\changeRequestUpdates;
use App\circularMaster;
use App\Exports\reportExport;
use App\Exports\reportExportForm;
use App\Libraries\aclHandler;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;


class crMfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (aclHandler::hasModuleAccess(['mf_cr_read','mf_cr_write']) == false){
            die('No access !');
        }

        return view('cr_mf.cr-mf-list');
    }


    public function getMfCrList(Request $request)
    {
        $business = trim($request->get('business'));
        $support = trim($request->get('support'));
        $ongoing = trim($request->get('ongoing'));
        $deployed = trim($request->get('deployed'));
        $configurable = trim($request->get('configurable'));
        $integration = trim($request->get('integration'));

        $hasDateVal = false;
        $deploy_start = $request->get('deploy_start');
        $deploy_end = $request->get('deploy_end');
        if ($deploy_start != '' && $deploy_end != ''){
            $hasDateVal = true;
            $deploy_start = date('Y-m-d',strtotime($request->get('deploy_start')));
            $deploy_end = date('Y-m-d',strtotime($request->get('deploy_end')));
        }

     //   $data = changeRequestMaster::orderBy('id', 'DESC')->get();
        $data = changeRequestMaster::where('is_archived', 0)
            ->where(function ($query) use ($business,$support,$configurable,$integration){
                if ($business == "true") {$query->orWhere('cr_type', 'Core_Business');}
                if ($support == "true") {$query->orWhere('cr_type', 'Support_CR');}
                if ($configurable  == "true") {$query->orWhere('cr_type', 'Configurable');}
                if ($integration  == "true") {$query->orWhere('cr_type', 'Integration');}
            })->where(function ($query) use ($ongoing,$deployed){
                if ($ongoing  == "true") {$query->orWhere('cr_status', 'Ongoing');}
                if ($deployed  == "true") {$query->orWhere('cr_status', 'Deployed');}
            })->where(function ($query) use ($deploy_start,$deploy_end,$deployed,$hasDateVal){
                if ($deployed  == "true" && $hasDateVal == true) {
                    $query->whereBetween('completed_on', [$deploy_start, $deploy_end]);
                }
            })->orderBy('priority', 'ASC')->get();


        return Datatables::of(collect($data))
            ->editColumn('cr_title', function ($data) {
                $formation = (strlen($data->cr_title) >40) ? ' ....':'';
                return substr($data->cr_title, 0, 40) . $formation;
            })->addColumn('action', function ($data) {
                $action = '';
                if(Auth::user()->type == 'SuperAdmin') {
                    $action = ' <button type="button" class="btn btn-xs btn-danger delete_cr" data-cr_id="' . $data->id . '"><b><i class="fa fa-trash"></i> Delete</b></button> &nbsp;';
                }
                $action .= '<button type="button" class="btn btn-xs open_cr_note_modal btn-info" data-cr_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> Notes</b></button> &nbsp;';
                if (aclHandler::hasActionAccess('mf_cr_write') == true) {
                    $action .= '<button type="button" class="btn btn-xs open_cr_edit_modal btn-info" data-cr_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> CR Edit</b></button>';
                }
                return $action;
            })->editColumn('jira_code', function ($data) {
                return '<a href="https://tim.brac.net/browse/'.$data->jira_code.'" target="_blank" style="color:#EC008C;">'.$data->jira_code.'</a>';
            })->editColumn('downloads', function ($data) {
                $docBtn = '';
                if(isset($data->cr_doc_link) && $data->cr_doc_link != ''){
                    $docBtn .= '<a class="btn btn-xs" href="'.url('final_cr_doc/'.$data->cr_doc_link).'" style="background-color:#009A93;color:white;" target="_blank">CR</a>';
                }
                if(isset($data->circular_doc) && $data->circular_doc != ''){
                    $docBtn .= '&nbsp;<a class="btn btn-xs" href="'.url('circular_doc/'.$data->circular_doc).'" style="background-color:#009A93;color:white;" target="_blank">Circular</a>';
                }
                return $docBtn;
            })->editColumn('vendor_proposed_timeline', function ($data) {
                if($data->vendor_proposed_timeline != null && $data->vendor_proposed_timeline != '' && $data->vendor_proposed_timeline != '0000-00-00')
                    return Carbon::parse($data->vendor_proposed_timeline)->format('d M Y');
                else
                    return 'Not set';

            })->editColumn('updated_at', function ($data) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->diffForHumans();
            })->editColumn('priority', function ($data) {
                return ($data->priority < 5) ? $data->priority : 'Not set';
            })
            ->removeColumn('id')
            ->rawColumns(['action','jira_code','downloads'])
            ->make(true);
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
            DB::commit();

            return response()->json( ['responseCode'=>1,'message'=>'Successfully created']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }
    }


    public function getCRInfo(Request $request)
    {
        $rules = [
            'cr_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $cr_id = trim($request->get('cr_id'));
        $crData = changeRequestMaster::where('id',$cr_id)->first();

        $public_html = strval(view("cr_mf.cr-mf-info-update-modal", compact('crData')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);
    }


    public function updateCRInfo(Request $request)
    {
        $rules = [
            'cr_id'       => 'required',
            'cr_title'       => 'required',
            'category'       => 'required',
            'vendor_name'    => 'required',
            'cr_details'     => 'required',
            'team_name'      => 'required',
            'requester_team' => 'required',
            'cr_type'        => 'required',
            'assigned_from_brac' => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required fields']);
        }

        $cr_id = trim($request->get('cr_id'));
        $jira_code = trim($request->get('jira_code'));
        if(isset($jira_code) && $jira_code != null && $jira_code != ""){
            $checkDuplicate = changeRequestMaster::where('jira_code','=',$jira_code)
                ->where('id','!=',$cr_id)->count();
            if ( $checkDuplicate > 0 ) {
                return response()->json( ['responseCode'=>0,'message'=>'Jira already created']);
            }
        }

        $cr_title = trim($request->get('cr_title'));
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

        $cr_doc = $request->file('cr_doc');
        $cr_doc_name = '';
        if ( $cr_doc ) {
            $replacedSubStr = substr(str_replace(" ","-",$cr_title), 0, 10);
            $cr_doc_name = $replacedSubStr.date('mdhis').rand(11,99) . '.' . $cr_doc->getClientOriginalExtension();
            $cr_doc->move(public_path('final_cr_doc'), $cr_doc_name);
        }

        $data = array(
            'cr_title'       => $cr_title,
            'category'       => $category,
            'vendor_name'    => $vendor_name,
            'cr_details'     => $cr_details,
            'team_name'      => $team_name,
            'requester_team' => $requester_team,
            'cr_type'        => $cr_type,
            'assigned_from_brac' => $assigned_from_brac,
            'updated_by' => Auth::user()->id
        );
        if(isset($jira_code) && $jira_code != null){$data['jira_code'] = $jira_code;}
        if(isset($cr_doc_name) && $cr_doc_name != ''){$data['cr_doc_link'] = $cr_doc_name;}
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
        if(isset($completed_on) && $completed_on != null){
            $data['completed_on'] = date("Y-m-d", strtotime($completed_on));
        }
        if(isset($jira_created) && $jira_created != null){
            $data['jira_created'] = date("Y-m-d", strtotime($jira_created));
        }
        if(isset($uat_credential) && $uat_credential != null){$data['uat_credential'] = $uat_credential;}
        if(isset($satisfactory_level) && $satisfactory_level != null){$data['satisfactory_level'] = $satisfactory_level;}

        try {

            DB::beginTransaction();
            changeRequestMaster::where('id',$cr_id)->update($data);
            circularMaster::where('cr_master_id',$cr_id)->update([
                'status'=>$cr_status,
                'status_changed_by_id'=>Auth::user()->id,
                'status_changed_by_name'=>Auth::user()->name
            ]);
            DB::commit();

            return response()->json( ['responseCode'=>1,'message'=>'Successfully updated']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }
    }

    public function getCRNoteInfo(Request $request)
    {
        $rules = [
            'cr_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $cr_id = trim($request->get('cr_id'));
        $crData = changeRequestMaster::where('id',$cr_id)->first();
        $crNoteData = changeRequestUpdates::where('cr_master_id',$cr_id)->orderBy('note_date','DESC')->get();
        $crCommentData = changeRequestComments::where('cr_master_id',$cr_id)->orderBy('comment_date','DESC')->get();

        $public_html = strval(view("cr_mf.cr-mf-notes-modal", compact('crData','crNoteData','crCommentData')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);
    }


    public function addNoteTemplate(Request $request)
    {
        $cr_master_id = intval($request->get('cr_master_id'));
        $crDuplicate = changeRequestUpdates::where('cr_master_id','=',$cr_master_id)->orderBy('id','DESC')->first();

        $public_html = strval(view("cr_mf.add-note-content",compact('crDuplicate')));
        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);
    }

    public function addCommentTemplate(Request $request)
    {
//        $cr_master_id = intval($request->get('cr_master_id'));
//        $crDuplicate = changeRequestUpdates::where('cr_master_id','=',$cr_master_id)->orderBy('id','DESC')->first();

        $public_html = strval(view("cr_mf.add-comment-content"));
        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);
    }


    public function addNewCRNotes(Request $request)
    {
        if (aclHandler::hasActionAccess('mf_cr_write') == false) {
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'note_type'       => 'required',
            'note_date'       => 'required',
            'cr_notes'    => 'required',
            'cr_master_id'     => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required fields']);
        }

        $note_type = trim($request->get('note_type'));
        $note_date = trim($request->get('note_date'));
        $cr_notes = $request->get('cr_notes');
        $cr_master_id = trim($request->get('cr_master_id'));

        $checkDuplicate = changeRequestUpdates::whereDate('note_date','=',date("Y-m-d", strtotime($note_date)))
            ->where('cr_master_id',$cr_master_id)->count();

        if ( $checkDuplicate > 0 ) {
            return response()->json( ['responseCode'=>0,'message'=>'Note already inserted for '.$note_date]);
        }

        $data = array(
            'cr_master_id'   => $cr_master_id,
            'note_type'      => $note_type,
            'cr_notes'       => $cr_notes,
            'note_date'      => date("Y-m-d", strtotime($note_date)),
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        );

        try {

            DB::beginTransaction();
            changeRequestUpdates::create($data);
            changeRequestMaster::where('id',$cr_master_id)->update([
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now()
            ]);
            DB::commit();

            $crNoteData = changeRequestUpdates::where('cr_master_id',$cr_master_id)->orderBy('note_date','DESC')->get();
            $public_html = strval(view("cr_mf.note-list", compact('crNoteData')));

            return response()->json( ['responseCode'=>1,'noteList'=>$public_html,'message'=>'Successfully created']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }
    }

    public function addNewCRComment(Request $request)
    {
        if (Auth::user()->type != 'Management') {
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'comment_type'       => 'required',
            'comment_date'       => 'required',
            'cr_comment'         => 'required',
            'cr_master_id'       => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required fields']);
        }

        $comment_type = trim($request->get('comment_type'));
        $comment_date = trim($request->get('comment_date'));
        $cr_comment = $request->get('cr_comment');
        $cr_master_id = trim($request->get('cr_master_id'));

        $checkDuplicate = changeRequestComments::whereDate('comment_date','=',date("Y-m-d", strtotime($comment_date)))
            ->where('cr_master_id',$cr_master_id)->count();

        if ( $checkDuplicate > 0 ) {
            return response()->json( ['responseCode'=>0,'message'=>'Comment already inserted for '.$comment_date]);
        }

        $data = array(
            'cr_master_id'   => $cr_master_id,
            'comment_type'      => $comment_type,
            'comment'       => $cr_comment,
            'comment_date'      => date("Y-m-d", strtotime($comment_date)),
            'comment_by' => Auth::user()->name,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        );

        try {

            DB::beginTransaction();
            changeRequestComments::create($data);
            DB::commit();

            $crCommentData = changeRequestComments::where('cr_master_id',$cr_master_id)->orderBy('comment_date','DESC')->get();
            $public_html = strval(view("cr_mf.comment-list", compact('crCommentData')));

            return response()->json( ['responseCode'=>1,'commentList'=>$public_html,'message'=>'Successfully created']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }
    }

    public function getNoteDetails(Request $request)
    {
        $rules = [
            'note_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }

        $note_id = trim($request->get('note_id'));
        $crNoteData = changeRequestUpdates::leftJoin('users', 'users.id', '=', 'change_request_updates.updated_by')
            ->where('change_request_updates.id',$note_id)->first([
                'change_request_updates.*',
                'users.name',
                'users.email'
            ]);

        $public_html = strval(view("cr_mf.inserted-note-content", compact('crNoteData')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);
    }

    public function getCommentDetails(Request $request)
    {
        $rules = [
            'comment_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }

        $comment_id = trim($request->get('comment_id'));
        $crCommentData = changeRequestComments::leftJoin('users', 'users.id', '=', 'change_request_comments.updated_by')
            ->where('change_request_comments.id',$comment_id)->first([
                'change_request_comments.*',
                'users.name',
                'users.email'
            ]);

        $public_html = strval(view("cr_mf.inserted-comment-content", compact('crCommentData')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);
    }

    public function updateCrNote(Request $request)
    {
        if (aclHandler::hasActionAccess('mf_cr_write') == false) {
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'note_type'       => 'required',
            'note_date'       => 'required',
            'cr_notes'        => 'required',
            'cr_master_id'    => 'required',
            'note_id'         => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required fields']);
        }

        $note_type = trim($request->get('note_type'));
        $note_date = trim($request->get('note_date'));
        $cr_notes = $request->get('cr_notes');
        $note_id = trim($request->get('note_id'));
        $cr_master_id = trim($request->get('cr_master_id'));

        $checkDuplicate = changeRequestUpdates::whereDate('note_date','=',date("Y-m-d", strtotime($note_date)))
            ->where('id','!=',$note_id)->where('cr_master_id','=',$cr_master_id)->count();

        if ( $checkDuplicate > 0 ) {
            return response()->json( ['responseCode'=>0,'message'=>'Note already inserted for '.$note_date]);
        }

        $data = array(
            'note_type'      => $note_type,
            'cr_notes'       => $cr_notes,
            'note_date'      => date("Y-m-d", strtotime($note_date)),
            'updated_by' => Auth::user()->id
        );

        try {

            DB::beginTransaction();
            changeRequestUpdates::where('id',$note_id)->update($data);
            changeRequestMaster::where('id',$cr_master_id)->update([
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now()
            ]);
            DB::commit();

            $crNoteData = changeRequestUpdates::where('cr_master_id',$cr_master_id)->orderBy('note_date','DESC')->get();
            $public_html = strval(view("cr_mf.note-list", compact('crNoteData')));

            return response()->json( ['responseCode'=>1,'noteList'=>$public_html,'message'=>'Successfully updated']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }
    }

    public function updateCrComment(Request $request)
    {
        if (Auth::user()->type != 'Management') {
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'comment_type'       => 'required',
            'comment_date'       => 'required',
            'cr_comment'        => 'required',
            'cr_master_id'    => 'required',
            'comment_id'         => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required fields']);
        }

        $comment_type = trim($request->get('comment_type'));
        $comment_date = trim($request->get('comment_date'));
        $cr_comment = $request->get('cr_comment');
        $comment_id = trim($request->get('comment_id'));
        $cr_master_id = trim($request->get('cr_master_id'));

        $checkDuplicate = changeRequestComments::whereDate('comment_date','=',date("Y-m-d", strtotime($comment_date)))
            ->where('id','!=',$comment_id)->where('cr_master_id','=',$cr_master_id)->count();

        if ( $checkDuplicate > 0 ) {
            return response()->json( ['responseCode'=>0,'message'=>'Comment already inserted for '.$comment_date]);
        }

        $data = array(
            'comment_type'      => $comment_type,
            'comment'       => $cr_comment,
            'comment_date'      => date("Y-m-d", strtotime($comment_date)),
            'updated_by' => Auth::user()->id
        );

        try {

            DB::beginTransaction();
            changeRequestComments::where('id',$comment_id)->where('created_by',Auth::user()->id)->update($data);
            DB::commit();

            $crCommentData = changeRequestComments::where('cr_master_id',$cr_master_id)->orderBy('comment_date','DESC')->get();
            $public_html = strval(view("cr_mf.comment-list", compact('crCommentData')));

            return response()->json( ['responseCode'=>1,'commentList'=>$public_html,'message'=>'Successfully updated']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }
    }

    public function excelExport(Request $request)
    {

        //return (new InvoicesExport)->download('invoices.csv', Excel::CSV, ['Content-Type' => 'text/csv']);
        // header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        // header("Content-Disposition: attachment; filename=JIRA_TASK_SUMMARY.csv");

        try {

            $business = trim($request->get('business'));
            $support = trim($request->get('support'));
            $ongoing = trim($request->get('ongoing'));
            $deployed = trim($request->get('deployed'));
            $configurable = trim($request->get('configurable'));
            $integration = trim($request->get('integration'));

            $hasDateVal = false;
            $deploy_start = $request->get('deploy_start');
            $deploy_end = $request->get('deploy_end');
            if ($deploy_start != '' && $deploy_end != ''){
                $hasDateVal = true;
                $deploy_start = date('Y-m-d',strtotime($request->get('deploy_start')));
                $deploy_end = date('Y-m-d',strtotime($request->get('deploy_end')));
            }

            return Excel::download(new reportExportForm($business,$support,$ongoing,$deployed,$configurable,$integration,$hasDateVal,$deploy_start,$deploy_end), 'JIRA_TASK_SUMMARY.xlsx');

        } catch (\Exception $e) {
            die('Something wrong');
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
        if (aclHandler::hasActionAccess('mf_cr_write') == false) {
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'cr_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        changeRequestMaster::where('id',$request->get('cr_id'))->delete();
        changeRequestUpdates::where('cr_master_id',$request->get('cr_id'))->delete();

        return response()->json( ['responseCode'=>1,'message'=>'Successfully deleted']);

    }
}
