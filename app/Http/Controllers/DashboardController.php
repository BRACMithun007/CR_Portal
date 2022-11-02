<?php

namespace App\Http\Controllers;

use App\changeRequestComments;
use App\changeRequestMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getGraphDataTblComment(Request $request)
    {

//        $rules = [
//            'comment_id'        => 'required'
//        ];
//        $validator = Validator::make( $request->all(), $rules );
//        if ( $validator->fails() ) {
//            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
//        }

        $cr_type = trim($request->get('cr_type'));
        $month_name = trim($request->get('month_name'));
        $crData = changeRequestMaster::where('cr_type',$cr_type)
            ->where('completed_on', '!=', null)
            ->where('completed_on', '!=', '')
            ->where( DB::raw('YEAR(completed_on)'), '=', date("Y") )
            ->where( DB::raw('DATE_FORMAT(completed_on, "%b")'), '=', $month_name )
            ->get();

        $modalHeaderText = 'Deployed item('.strtolower($cr_type).') list in '.$month_name.' '.date("Y");
        $public_html = strval(view("dashboard.graph_table_content",compact('crData','modalHeaderText')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);
    }


    public function getChartDataTblComment(Request $request)
    {

//        $rules = [
//            'comment_id'        => 'required'
//        ];
//        $validator = Validator::make( $request->all(), $rules );
//        if ( $validator->fails() ) {
//            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
//        }

        $status_name = trim($request->get('status_name'));
        $crData = changeRequestMaster::where('cr_status',$status_name)
            ->get();

        $modalHeaderText = $status_name.' Item list';
        $public_html = strval(view("dashboard.chart_table_content",compact('crData','modalHeaderText')));

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
