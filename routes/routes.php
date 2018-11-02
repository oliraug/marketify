<?php

Route::get('category/{id}', 'CategoriesController@get_create_category_name');
Route::post('category', 'CategoriesController@post_create_category');
Route::get('category/{id}', 'CategoriesController@get_create_category');
Route::get('category/{id}', 'CategoriesController@get_update_category');
Route::delete('category/{id}', 'CategoriesController@get_delete_category');
Route::put('category/{id}', 'CategoriesController@post_update_category');

Route::group(['prefix' => 'api/v1', 'middleware' => 'api'], function(){
 Route::resource('categories', 'CategoryController');
});
	
Route::get('olify_category', function()
{
		$categories = DB::table('olify_category')->get();
		return View::make('olify_category')->with('categories', $categories);
});

Route::post('olify_category', function()
{
	$data = array(
		'category_name' => Input::get('category_name'),
		'category_status' => Input::get('category_status'),
		'description' => Input::get('description'));

		DB::table('olify_category')->insert($data);

		return Redirect::to('olify_category');
});

?>