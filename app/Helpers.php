<?php
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

function createBase64($string) {
    $urlCode = base64_encode($string);
    return str_replace(array('+','/','='),array('-','_',''),$urlCode);
}

function decodeBase64($base64ID) {
    $data = str_replace(array('-','_'),array('+','/'),$base64ID);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
            $data .= substr('====', $mod4);
    }
    return base64_decode($data);
}

function debug($arr, $exit = false)
{
    print "<pre>";
        print_r($arr);
    print "</pre>";
    if($exit)
        exit;
}

function permissions()
{
    $user = Auth::user();
	$prr = [];
	$prr['role'] = $user->role;
	foreach ($user->admin_permissions as $pemision) {
	  $prr[$pemision->permission] = true;
	}
	return $prr;
}

function getLastInsertId(){
   return DB::getPdo()->lastInsertId();
}

?>