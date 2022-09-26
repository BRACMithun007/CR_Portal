<?php

namespace App\Http\Controllers;

use App\Libraries\aclHandler;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class cmsUserController extends Controller
{

    public $email_sender_add = 'noreply.icec.portal@gmail.com';
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (aclHandler::hasModuleAccess(['user_read','user_write']) == false){
            die('No access !');
        }
        return view('cms_user.user-list');
    }

    public function getUserList()
    {
        $data = User::where('type','!=','SuperAdmin')->orderBy('id', 'DESC')->get();

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '';
                if($data->type != 'SuperAdmin') {
                    if (Auth::user()->type == 'SuperAdmin') {
                        $action = ' <button type="button" class="btn btn-danger btn-xs deleteUser" data-user_id="' . $data->id . '"><b><i class="fa fa-trash"></i> Delete</b></button> &nbsp;';
                    }
                    if (aclHandler::hasActionAccess('user_write') == true) {
                        $action .= '<button type="button" class="btn btn-info btn-xs open_user_modal" data-user_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> Edit</b></button>';
                    }
                }
                return $action;
            })->editColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="label label-primary"><b>Active</b></span>';
                } else {
                    return '<span class="label label-danger"><b>In-active</b></span>';
                }
            })->editColumn('updated_at', function ($data) {
                return $update_was = Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->diffForHumans();
            })
            ->removeColumn('id')
            ->rawColumns(['action','status'])
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
        if (aclHandler::hasActionAccess('user_write') == false) {
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'user_name'  => 'required',
            'email'    => 'required|unique:users|max:255',
            'user_type'   => 'required',
            'user_phone'   => 'required',
            'user_country'   => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $email = trim($request->get('email'));
        $user_permission = $request->get('user_permission');
        $user_name = trim($request->get('user_name'));
        $user_type = $request->get('user_type');
        $user_phone = trim($request->get('user_phone'));
        $user_country = trim($request->get('user_country'));
        $user_occupation = '';
        $user_designation = $request->get('user_designation');
        $pass = rand(100000, 999999);
        $data = array(
            'name' => $user_name,
            'email' => $email,
            'password' => $pass,
            'type' => "Admin",
        );

        try {

            DB::beginTransaction();
            $User = new User();
            $User->name = $user_name;
            $User->email = $email;
            $User->type = $user_type;
            $User->phone = $user_phone;
            $User->status = 1;
            $User->country = $user_country;
            $User->password = bcrypt($pass);
            $User->occupation = $user_occupation;
            $User->designation = $user_designation;
            $User->user_permission = json_encode($user_permission);
            $User->save();

//            \Mail::send('emailTemplateAddUser', $data, function ($message) use ($email) {
//                $message->from($this->email_sender_add, 'ICEC')
//                    ->to($email)
//                    ->subject('Registration Credentials (ICEC)');
//            });

            DB::commit();

            return response()->json( ['responseCode'=>1,'message'=>'Successfully inserted']);

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
    public function getUserInfo(Request $request)
    {

        $rules = [
            'user_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $user_id = $request->get('user_id');
        $userData = User::where('id',$user_id)->first();

        $userPermission = json_decode($userData->user_permission);

        $public_html = strval(view("cms_user.user-info-update-modal", compact('userData','userPermission')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);


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
    public function updateUserInfo(Request $request)
    {
        if (aclHandler::hasActionAccess('user_write') == false) {
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'user_name'  => 'required',
            'user_id'    => 'required',
            'user_type'   => 'required',
            'user_phone'   => 'required',
            'user_country'   => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $user_id = trim($request->get('user_id'));
        $user_name = trim($request->get('user_name'));
        $user_type = $request->get('user_type');
        $user_phone = trim($request->get('user_phone'));
        $user_country = trim($request->get('user_country'));
        $user_occupation = '';
        $user_designation = $request->get('user_designation');
        $user_permission = $request->get('user_permission');

        try {

            DB::beginTransaction();
            User::where('id',$user_id)->update([
                'name' =>$user_name,
                'type' =>$user_type,
                'phone' =>$user_phone,
                'country' =>$user_country,
                'occupation' =>$user_occupation,
                'designation' =>$user_designation,
                'user_permission' =>json_encode($user_permission)
            ]);

            DB::commit();

            return response()->json( ['responseCode'=>1,'message'=>'Successfully updated']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json( ['responseCode'=>0,'message'=>'Something wrong']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (aclHandler::hasActionAccess('user_write') == false) {
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'user_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        User::where('id',$request->get('user_id'))->delete();

        return response()->json( ['responseCode'=>1,'message'=>'Successfully deleted']);

    }
}
