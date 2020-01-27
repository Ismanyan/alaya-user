<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
    DEFAULT URL
*/ 
$route['default_controller'] = 'Controller';
$route['statistic'] = 'Controller/statistic';
$route['assets/(:any)'] = 'assets/$1';
$route['404_override'] = 'controller/page_not_found';
$route['translate_uri_dashes'] = TRUE;

/*
    CUTOM URL
    =========================================
    (:num) is used to determine the relevant segment in the form of numbers
    (:any) is used to determine the relevant segments in all characters
*/ 
// AUTH CONTROLLER
$route['login'] = 'AuthController/login';
$route['login/check'] = 'AuthController/check_login';
$route['pin'] = 'AuthController/pin';
$route['pin/check/(:any)'] = 'AuthController/pin_check/$1';
$route['logout'] = 'Controller/logout';

// PROFILE CONTROLLER
$route['profile'] = 'ProfileController/index';
$route['profile/get/(:num)'] = 'ProfileController/getProfile/$1';

// TREATMENT CONTROLLER
$route['treatment'] = 'TreatmentController/index';
$route['treatment/get/all'] = 'TreatmentController/getTreatmentAll';
$route['treatment/detail/(:num)'] = 'TreatmentController/detail/$1';
$route['treatment/get/detail/(:num)'] = 'TreatmentController/getDetail/$1';
$route['treatment/count/(:num)'] = 'TreatmentController/count/$1';
$route['treatment/post/count'] = 'TreatmentController/postCounting';
$route['treatment/history'] = 'TreatmentController/history';
$route['treatment/get/history/(:num)'] = 'TreatmentController/getTreatmentHistory/$1';
$route['treatment/history/detail/(:num)'] = 'TreatmentController/treatmentHistoryDetail/$1';
$route['treatment/get/history/detail/(:num)'] = 'TreatmentController/getTreatmentHistoryDetail/$1';

// ABSENT CONTROLLER
$route['location/(:any)/(:any)'] = 'GeoController/index/$1/$2';
$route['absent'] = 'AbsentController/index';
$route['absent/add'] = 'AbsentController/absentAdd';
$route['absent/history'] = 'AbsentController/history';
$route['absent/history/detail/(:num)'] = 'AbsentController/absentHistoryDetail/$1';
$route['absent/get/history/(:num)'] = 'AbsentController/getAbsentHistory/$1';
$route['absent/get/history/detail/(:num)'] = 'AbsentController/getAbsentHistoryDetail/$1';