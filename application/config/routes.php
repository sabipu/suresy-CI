<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'dashboard';

$route['login'] = 'login/index';
$route['forgot/:any'] = 'login/recover';

$route['forgot'] = 'login/forgot';
$route['logout'] = 'login/logoutWithMsg';

$route['dashboard'] = 'dashboard/index';

$route['profile'] = 'profile/index';
$route['profile/update'] = 'profile/update';
// $route['profile/deactivate'] = 'profile/deactivate';

$route['messages'] = 'account/messages';
$route['messages/:any/reply'] = 'account/message_reply';
$route['messages/:any'] = 'account/message_view';



$route['claims'] = 'claims/index'; // see all customer claims
$route['claims/remove/:any'] = 'claims/remove'; // json response
$route['claims/add'] = 'claims/make'; // show claim add form
$route['claim/make'] = 'claims/make'; // show claim add form
$route['claims/make'] = 'claims/make'; // show claim add form
$route['claims/make/new'] = 'claims/make_new'; // ajax to save claim
$route['claims/make/upload'] = 'claims/make_upload'; // ajax to save claim
$route['claims/make/upload/remove'] = 'claims/make_upload_remove'; // remove an upload

$route['claims/payout/:any'] = 'claims/payout'; // ask for payment info
$route['claims/:any'] = 'claims/view'; // show a claim and allow user to edit or view message


$route['policy'] = 'policies/view';
$route['all-policies'] = 'policies/allpolicies';
$route['policy/cancel/:any'] = 'policies/cancel';
$route['policy/pause/:any'] = 'policies/pause';
$route['policy/update/:num'] = 'policies/update';
$route['policy/update/changes/:num'] = 'policies/saveUpdates';
$route['policy/download/:any'] = 'policies/download'; // present policy pdf

$route['billing'] = 'billing/view';
$route['billing/update/:any'] = 'billing/update';
$route['billing/remove/:any'] = 'billing/remove';
$route['billing/add'] = 'billing/add';
$route['billing/history'] = 'billing/history';
$route['billing/history/:any'] = 'billing/history_view';
$route['billing/history/print'] = 'billing/history_print';
//$route['billing/playground'] = 'billing/playground';

$route['billing/playground/submit'] = 'billing/playground_submit';
// $route['billing/playground/submit'] = 'billing/testTransaction';



// Quote response
$route['api/calculator/payment'] = 'payment/make';
$route['quote/calculator/success'] = 'confirm/success';
$route['api/calculator/postcode'] = 'calculator/postcodeAvailable';
$route['api/calculator/email'] = 'calculator/emailAvailable';



// API STUFF
$route['api/calculator/subscribe'] = 'payment/make';

$route['api/calculator/quote'] = 'calculator/quote';
$route['api/calculator/quote/save'] = 'calculator/saveAjaxPolicyDataFromCalculator';
$route['calculator/playground'] = 'calculator/playground';
$route['playground'] = 'playground/import';
$route['playground/postcodes'] = 'playground/importPostCodeCSV';

$route['playground/debuginfo'] = 'playground/debugInfo';

$route['playground/email/:any'] = 'playground/email';
$route['playground/password'] = 'playground/makePasswordTest';

$route['newsletter/subscribe'] = 'newsletter/subscribe';

$route['backstage/admin/rate/manager/:num'] = 'RateEngine/viewRates';
$route['backstage/admin/rate/manager/update'] = 'RateEngine/updateRate';
$route['backstage/admin/policies/export'] = 'exporter/exportCSV';


$route['backstage/admin/rate/manager'] = 'RateEngine/viewRates';
$route['backstage/admin/promocode/manager'] = 'RateEngine/viewPromocodes';
$route['backstage/admin/promocode/manager/update'] = 'RateEngine/updatePromocode';
$route['backstage/admin/promocode/manager/add'] = 'RateEngine/addPromocode';
$route['backstage/admin/promocode/manager/delete'] = 'RateEngine/deletePromocode';



$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



