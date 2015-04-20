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
$route['terms'] = 'site/terms';
$route['privacy'] = 'site/privacy';
$route['browse'] = 'site/account/profiles/__/__/__/__/__/created/__/$1';
$route['browse/(:num)'] = 'site/account/profiles/__';
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

$route['profile/like/(:num)'] = 'site/profile/like_profile/$1/true';
$route['profile/like/(:num)/(:any)'] = 'site/profile/like_profile/$1/true/$2';
$route['profile/unlike/(:num)'] = 'site/profile/unlike_profile/$1/true';
$route['profile/unlike/(:num)/(:any)'] = 'site/profile/unlike_profile/$1/true/$2';
$route['messages/inbox'] = 'site/messages/inbox';
$route['messages/inbox'] = 'site/messages/inbox';
$route['messages/inbox/(:num)'] = 'site/messages/inbox/__/created/$1';
$route['messages/inbox/(:any)'] = 'site/messages/view_message/$1';
$route['likes-me'] = 'site/profile/likes_me';
$route['likes-me/(:num)'] = 'site/profile/likes_me/$1';
$route['i-like'] = 'site/profile/i_like';
$route['i-like/(:num)'] = 'site/profile/i_like/$1';

$route['credits'] = 'site/subscription/subscribe';
$route['payment'] = 'site/subscription/payment';
$route['process-payment/(:any)/(:any)'] = 'site/subscription/process_payment/$1/$2';

$route['forgot-password'] = 'login/forgot_password';

/*
*	Sign up Routes
*/
$route['sign-in'] = 'login/login_client';
$route['sign-out'] = 'login/logout_user';
$route['join'] = 'login/register_user';
$route['register/about-you'] = 'site/profile/about_you';
$route['my-profile'] = 'site/profile/edit_profile';
$route['update-password'] = 'site/profile/update_password';

/*
*	Account Routes
*/
$route['my-account'] = 'site/account';
$route['error'] = 'site/account/error';
/*
*	Clients Routes
*/
$route['all-clients'] = 'admin/clients/index';//normal
$route['all-clients/(:num)'] = 'admin/clients/index/$1';//pagination
$route['all-clients/(:any)/(:any)'] = 'admin/clients/index/$1/$2';//sorting
$route['all-clients/(:any)/(:any)/(:num)'] = 'admin/clients/index/$1/$2/$3';//sorting & pagination
$route['add-client'] = 'admin/clients/add_client';
$route['edit-client/(:num)'] = 'admin/clients/edit_client/$1';
$route['delete-client/(:num)'] = 'admin/clients/delete_client/$1';
$route['activate-client/(:num)'] = 'admin/clients/activate_client/$1';
$route['deactivate-client/(:num)'] = 'admin/clients/deactivate_client/$1';

/*
*	Messages Routes
*/
$route['all-messages'] = 'admin/messages/index';//normal
$route['all-messages/(:num)'] = 'admin/messages/index/$1';//pagination
$route['all-messages/(:any)/(:any)'] = 'admin/messages/index/$1/$2';//sorting
$route['all-messages/(:any)/(:any)/(:num)'] = 'admin/messages/index/$1/$2/$3';//sorting & pagination
$route['add-message'] = 'admin/messages/add_message';
$route['edit-message/(:num)'] = 'admin/messages/edit_message/$1';
$route['delete-message/(:num)'] = 'admin/messages/delete_message/$1';
$route['activate-message/(:num)'] = 'admin/messages/activate_message/$1';
$route['deactivate-message/(:num)'] = 'admin/messages/deactivate_message/$1';
$route['view-chat/(:num)/(:num)/(:num)'] = 'admin/messages/view_chat/$1/$2/$3';

/*
*	Settings Routes
*/
$route['settings'] = 'admin/settings';
$route['dashboard'] = 'admin/index';

/*
*	Login Routes
*/
$route['login-admin'] = 'login/login_admin';
$route['logout-admin'] = 'login/logout_admin';

/*
*	Users Routes
*/
$route['all-users'] = 'admin/users';
$route['all-users/(:num)'] = 'admin/users/index/$1';
$route['add-user'] = 'admin/users/add_user';
$route['edit-user/(:num)'] = 'admin/users/edit_user/$1';
$route['delete-user/(:num)'] = 'admin/users/delete_user/$1';
$route['activate-user/(:num)'] = 'admin/users/activate_user/$1';
$route['deactivate-user/(:num)'] = 'admin/users/deactivate_user/$1';
$route['reset-user-password/(:num)'] = 'admin/users/reset_password/$1';
$route['admin-profile/(:num)'] = 'admin/users/admin_profile/$1';


/* End of file routes.php */
/* Location: ./application/config/routes.php */