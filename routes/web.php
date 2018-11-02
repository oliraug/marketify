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
use Illuminate\Http\Request;

Route::get('/', function () {
	$links = \App\Link::all();
	$categories = \App\Category::all();
    return view('welcome', ['links' => $links], ['categories' => $categories]);
});

Route::get('/submit', function () {
    return view('submit');
});

//Submitting the Link Form
Route::post('/submit', function (Request $request) {
    $data = $request->validate([
        'title' => 'required|max:255',
        'url' => 'required|url|max:255',
        'description' => 'required|max:255',
    ]);

    $link = tap(new App\Link($data))->save();

    return redirect('/');
});


Route::group(['prefix' => 'api/v1', 'middleware' => 'api'], function(){
 Route::resource('categories', 'CategoryController');
 Route::resource('users', 'Auth\RegisterController');
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

Route::post('register', function()
{
	$user = new User;
	$user->full_name = Input::get('full_name');
	$user->login_name = Input::get('login_name');
	$user->password = Input::get('password');
	$user->phone_no = Input::get('phone_no');
	$user->sex = Input::get('sex');
	$user->speciality = Input::get('speciality');
	$user->enabled = Input::get('enabled');
	$user->user_type = Input::get('user_type');
	$user->save();

	return Redirect::to('login')
			->with('message', 'You may now sign in!');

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('category/{id}', 'CategoriesController@index');
Route::post('category', 'CategoriesController@create');
Route::get('category/{id}', 'CategoriesController@store');
Route::get('category/{id}', 'CategoriesController@show');
Route::delete('category/{id}', 'CategoriesController@destroy');
Route::put('category/{id}', 'CategoriesController@update');

