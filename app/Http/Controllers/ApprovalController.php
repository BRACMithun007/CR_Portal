<?php

namespace App\Http\Controllers;

use App\circularMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //        if (aclHandler::hasModuleAccess(['mf_cr_read','mf_cr_write']) == false){
//            die('No access !');
//        }

        return view('mf_approval.mf-approval-list');
    }


    public function getApprovalList(Request $request)
    {

        $data = circularMaster::where('is_archived', 0)->where('status', '2')
            ->orderBy('created_at', 'ASC')->get();


        return Datatables::of(collect($data))
            ->editColumn('title', function ($data) {
                $formation = (strlen($data->cr_title) >40) ? ' ....':'';
                return substr($data->cr_title, 0, 40) . $formation;
            })->addColumn('action', function ($data) {
                $action = '';
                if(Auth::user()->type == 'SuperAdmin') {
                    $action = ' <button type="button" class="btn btn-xs delete_cr" style="background-color:#009A93;color:white;" data-cr_id="' . $data->id . '"><b><i class="fa fa-trash"></i> Delete</b></button> &nbsp;';
                }
                $action .= '<button type="button" class="btn btn-xs open_cr_note_modal" style="background-color:#009A93;color:white;" data-cr_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> Notes</b></button> &nbsp;';
//                if (aclHandler::hasActionAccess('mf_cr_write') == true) {
//                    $action .= '<button type="button" class="btn btn-xs open_cr_edit_modal" style="background-color:#EC008C;color:white;" data-cr_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> CR Edit</b></button>';
//                }
                return $action;
            })->editColumn('downloads', function ($data) {
                $docBtn = '';
                if(isset($data->circular_doc) && $data->circular_doc != ''){
                    $docBtn .= '<a class="btn btn-xs" href="'.url('mf_circular_doc/'.$data->circular_doc).'" style="background-color:#009A93;color:white;" target="_blank">Circular</a>';
                }
                return $docBtn;
            })->editColumn('request_on', function ($data) {
                if($data->request_on != null && $data->request_on != '' && $data->request_on != '0000-00-00')
                    return $request_on = Carbon::parse($data->request_on)->format('d M Y');
                else
                    return $request_on = 'Not set';

            })->editColumn('updated_at', function ($data) {
                return $update_was = Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->diffForHumans();
            })
            ->removeColumn('id')
            ->rawColumns(['action','downloads'])
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
