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


//============= Product Section Start ================//
$route['product'] = 'ProductController';
$route['get-products'] = 'ProductController/getProducts';
$route['save-product'] = 'ProductController/addProduct';
$route['update-product'] = 'ProductController/updateProduct';
$route['delete-product'] = 'ProductController/deleteProduct';
$route['get-product-code'] = 'ProductController/productCode';
$route['get-selected-products'] = 'ProductController/getSelectedProducts';
//============= Product Section End ================//

//============= Group Section Start ================//
$route['group'] = 'GroupController';
$route['get-groups'] = 'GroupController/getGroups';
$route['save-group'] = 'GroupController/addGroup';
$route['update-group'] = 'GroupController/updateGroup';
$route['delete-group'] = 'GroupController/deleteGroup';
$route['get-seleted-groups'] = 'GroupController/getSelectedGroups';
//============= Group Section End ================//


//============= Product purchase Section Start ================//
$route['product-purchase'] = 'PurchaseController';
$route['product-purchase/(:num)'] = 'PurchaseController/productPurchaseEdit/$1';
$route['get-single-purchase-data'] = 'PurchaseController/getSinglePurchase';
$route['purchase-report'] = 'PurchaseController/purchaseReport';
$route['get-purchase-reports'] = 'PurchaseController/getPurchaseReports';
$route['save-purchase'] = 'PurchaseController/purchaseOrder';
$route['product-purchase-invoice/(:any)'] = 'PurchaseController/purchaseInvoice/$1';
$route['check-already-exist'] = 'PurchaseController/checkAlreadyExits';
$route['update-purchase'] = 'PurchaseController/purchaseUpdateProcess';
//============= Product purchase Section End ================//

//============= Supplier Start ================//
$route['get-selected-suppliers'] = 'SupplierController/getSeletedSuppliers';
//============= Supplier End ================//

//============= Basic Start ================//
$route['get-branch-info'] = 'BasicController/getBranchInfo';
$route['get-purchase-invoice'] = 'BasicController/getPurchaseInvoice';
//============= Basic End ================//

//============= Stock Start ================//
$route['stock'] = 'StockController';
$route['get-current-stock'] = 'StockController/getCurrentStock';
//============= stak End ================//



$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

