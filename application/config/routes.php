<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'FuckController';

//============= login Section Start ================//
$route['path'] = 'FuckController';
$route['path-process'] = 'FuckController/loginProcess';
$route['logout'] = 'FuckController/logout';

//============= login Section End ================//
$route['home'] = 'HomeController';

//============= Unit Section Start ================//
$route['unit'] = 'UnitController';
$route['get-units'] = 'UnitController/getUnits';
$route['save-unit'] = 'UnitController/addUnit';
$route['update-unit'] = 'UnitController/updateUnit';
$route['delete-unit'] = 'UnitController/deleteUnit';

//============= Unit Section End ================//

//============= Color Section Start ================//
$route['color'] = 'ColorController';
$route['get-colors'] = 'ColorController/getColors';
$route['save-color'] = 'ColorController/addColor';
$route['update-color'] = 'ColorController/updateColor';
$route['delete-color'] = 'ColorController/deleteColor';

//============= Color Section End ================//





$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

