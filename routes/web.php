<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('index',[
	'as'=>'trang-chu',
	'uses'=>'PageController@getIndex'
]);

Route::get('loai-san-pham/{type}',[
	'as'=>'loaisanpham',
	'uses'=>'PageController@getLoaiSp'
]);

Route::get('chi-tiet-san-pham/{id}',[
	'as'=>'chitietsanpham',
	'uses'=>'PageController@getChitiet'
]);

Route::get('lien-he',[
	'as'=>'lienhe',
	'uses'=>'PageController@getLienHe'
]);

Route::get('gioi-thieu',[
	'as'=>'gioithieu',
	'uses'=>'PageController@getGioiThieu'
]);
 //thêm vào rỏ hàng
Route::get('add-to-cart/{id}',[
	'as'=>'themgiohang',
	'uses'=>'PageController@getAddtoCart'

]);
 //xóa vào rỏ hàng
Route::get('del-cart/{id}',[
	'as'=>'xoagiohang',
	'uses'=>'PageController@getDelItemCart'
]);

Route::get('dat-hang',[
	'as'=>'dathang',
	'uses'=>'PageController@getCheckout'
]);

Route::post('dat-hang',[
	'as'=>'dathang',
	'uses'=>'PageController@getpostCheckout'
]);

Route::get('dang-nhap',[
	'as'=>'login',
	'uses'=>'PageController@getLogin'
]);


Route::post('dang-nhap',[
	'as'=>'login',
	'uses'=>'PageController@postLogin'
]);

Route::get('dang-ki',[
	'as'=>'signin',
	'uses'=>'PageController@getSignin'
]);


Route::post('dang-ki',[
	'as'=>'signin',
	'uses'=>'PageController@postSignin'
]);

Route::get('dang-xuat',[
	'as'=>'logout',
	'uses'=>'PageController@postLogout'
]);

Route::get('search',[
	'as'=>'search',
	'uses'=>'PageController@getSearch'
]);

Route::get('admin',function(){
	return view('admin.theloai.danhsach');
});

Route::get('logout',[
	'as'=>'logout',
	'uses'=>'PageController@getLogout'
]);
Route::get('logoutindex',[
	'as'=>'logoutindex',
	'uses'=>'PageController@getLogout1'
]);

Route::get('admin/dangnhap','UserController@getDangnhapAdmin');
Route::post('admin/dangnhap','UserController@postDangnhapAdmin');

Route::group(['prefix'=>'admin'],function(){
	Route::group(['prefix'=>'theloai'],function(){

		// truy cập danh sách thể loại
		// admin/theloai/danhsach
		Route::get('danhsach','PageController@getDanhSach');

		Route::get('sua/{id}','PageController@getSua');
		Route::post('sua/{id}','PageController@postSua');

		Route::get('them','PageController@getThem');
		Route::post('them','PageController@postThem');

		Route::get('xoa/{id}','PageController@getXoa');
	});

	Route::group(['prefix'=>'loaitin'],function(){
		// truy cập danh sách thể loại
		// admin/theloai/danhsach
		Route::get('danhsach','PageController@getDanhSach');

		Route::get('sua','PageController@getSua');

		Route::get('them','PageController@getThem');
	});

	Route::group(['prefix'=>'tintuc'],function(){
		// truy cập danh sách thể loại
		// admin/theloai/danhsach
		Route::get('danhsach','PageController@getDanhSach');

		Route::get('sua','PageController@getSua');

		Route::get('them','PageController@getThem');
	});

	Route::group(['prefix'=>'user'],function(){
		// truy cập danh sách thể loại
		// admin/theloai/danhsach
		Route::get('danhsach','UserController@getDanhSach');

		Route::get('sua/{id}','UserController@getSua');
		Route::post('sua/{id}','UserController@postSua');

		Route::get('them','UserController@getThem');
		Route::post('them','UserController@postThem');
	});


	// Route::group(['prefix'=>'user'],function(){
	// Route::group(['prefix'=>'theloai'],function(){
	// 	// truy cập danh sách thể loại
	// 	// admin/theloai/danhsach
	// 	Route::get('danhsach','PageController@getDanhSach');

	// 	Route::get('sua/{id}','PageController@getSua');
	// 	Route::post('sua/{id}','PageController@postSua');

	// 	Route::get('them','PageController@getThem');
	// 	Route::post('them','PageController@postThem');

	// 	Route::get('xoa/{id}','PageController@getXoa');
	// });

	Route::get('add-product.html/{id?}','AdminController@addProduct')->name("addProduct");
    Route::post('add-product.html','AdminController@postAddProduct')->name('postAddProduct');
    Route::get('list-product.html', 'AdminController@showProduct')->name('list-product');
    Route::get('delete-product.html/{id?}', 'AdminController@deleteProduct')->name('delete-product');
  	Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
});

