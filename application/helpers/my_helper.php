<?php
defined('BASEPATH') or exit('No direct script access allowed!');

function checkPermission($permission_name)
{
    $CI = get_instance();
    $CI->load->model('EISDatatex/Setting/PermissionModel');
    $userid = isset($_COOKIE['x-userid-' . strtolower(str_replace(' ', '', getenv('APP_NAME')))]) &&
        !empty($_COOKIE['x-userid-' . strtolower(str_replace(' ', '', getenv('APP_NAME')))]) ? $_COOKIE['x-userid-' . strtolower(str_replace(' ', '', getenv('APP_NAME')))] : null;
    $user_id = base64_decode($userid);
    $checkPermission = $CI->PermissionModel->checkPermission($user_id, $permission_name);
    
    return $checkPermission;
}

function check_approval($user_id)
{
	$CI =& get_instance();
	$CI->load->model('EISDatatex/Setting/PermissionModel');    
    return $CI->PermissionModel->check_approval($user_id);
}
