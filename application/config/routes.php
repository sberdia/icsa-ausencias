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
$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
Los siguientes ruteos pueden pensarse para exponer APIs Rest

$route['product/(:any)'] = 'catalog/product_lookup';
A URL with “product” as the first segment, and anything in the second will be remapped to the “catalog” class and the “product_lookup” method.
$route['product/(:num)'] = 'catalog/product_lookup_by_id/$1';
A URL with “product” as the first segment, and a number in the second will be remapped to the “catalog” class and the “product_lookup_by_id” method passing in the match as a variable to the method.


Using HTTP verbs in routes

It is possible to use HTTP verbs (request method) to define your routing rules. This is particularly useful when building RESTful applications. You can use standard HTTP verbs (GET, PUT, POST, DELETE, PATCH) or a custom one such (e.g. PURGE). HTTP verb rules are case-insensitive. All you need to do is to add the verb as an array key to your route. Example:

$route['products']['put'] = 'product/insert';
In the above example, a PUT request to URI “products” would call the Product::insert() controller method.

$route['products/(:num)']['DELETE'] = 'product/delete/$1';
A DELETE request to URL with “products” as first the segment and a number in the second will be mapped to the Product::delete() method, passing the numeric value as the first parameter.

Using HTTP verbs is of course, optional.
*/
