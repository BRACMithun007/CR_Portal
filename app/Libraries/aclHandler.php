<?php


namespace App\Libraries;


use Illuminate\Support\Facades\Auth;

class aclHandler
{
    public static function hasModuleAccess($modulePermissionArr = []){

        $authUserPermission = Auth::user()->user_permission;
        $userPermission = json_decode($authUserPermission);

        if (empty($userPermission)) {return false;}
        $commonArrVal=array_intersect($modulePermissionArr,$userPermission);
        if (empty($commonArrVal)){return false;}

        return true;

    }

    public static function hasActionAccess($actionPermission = ''){

        $authUserPermission = Auth::user()->user_permission;
        $userPermission = json_decode($authUserPermission);

        if (empty($userPermission)) {return false;}
        if (!in_array($actionPermission,$userPermission)){return false;}

        return true;

    }

}
