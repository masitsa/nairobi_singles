<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "site";
$route['404_override'] = '';

/*
*	Site Routes
*/
$route['home'] = 'site/home_page';
$route['browse'] = 'site/account/profiles/__';
$route['browse/filter-age/(:any)'] = 'site/account/profiles/__/__/__/$1/__/created';
$route['browse/filter-age'] = 'site/account/filter_age';
$route['browse/filter-gender/(:any)'] = 'site/account/profiles/__/__/$1/__/__/created';
$route['browse/filter-gender'] = 'site/account/filter_gender';
$route['browse/filter-encounter/(:any)'] = 'site/account/profiles/__/__/__/__/$1/created';
$route['browse/filter-encounter'] = 'site/account/filter_encounter';
$route['browse/filter-neighbourhood/(:any)'] = 'site/account/profiles/__/$1/__/__/__/created';
$route['browse/filter-neighbourhood'] = 'site/account/filter_neighbourhood';
$route['browse/sort-by/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'site/account/profiles/__/$2/__/$3/$4/$1/$5';
$route['browse/(:any)'] = 'site/account/view_profile/$1';

$route['messages/inbox'] = 'site/messages/inbox';
$route['messages/inbox/(:any)'] = 'site/messages/view_message/$1';

$route['credits'] = 'site/subscription/subscribe';
$route['payment'] = 'site/subscription/payment';

$route['forgot-password'] = 'login/forgot_password';

/*
*	Sign up Routes
*/
$route['sign-in'] = 'login/login_client';
$route['sign-out'] = 'login/logout_user';
$route['join'] = 'login/register_user';
$route['register/about-you'] = 'site/profile/about_you';
$route['my-profile'] = 'site/profile/edit_profile';

/*
*	Account Routes
*/
$route['my-account'] = 'site/account';


/* End of file routes.php */
/* Location: ./application/config/routes.php */