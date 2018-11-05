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
Route::get('/', function(){
	return view('index');
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

//To get a list of categories	
Route::get('olify_category', function()
{
		$categories = DB::table('olify_category')->get();
		return View::make('olify_category')->with('categories', $categories);
});

//The route takes form input and saves it to a new row in our category table in a database
Route::post('olify_category', array('before'=>'csrf', function()
{
	$data = array(
		'category_name' => Input::get('category_name'),
		'category_status' => Input::get('category_status'),
		'description' => Input::get('description'));

		DB::table('olify_category')->insert($data);

		return Redirect::to('olify_category');
}));

//To get a list of users
Route::get('users', function()
{
		$users = DB::table('users')->get();
		return View::make('users')->with('users', $users);
});
//For registering users in the users table
Route::post('users', array('before'=>'csrf', function()
{
	
	$rules = array(
		'full_name'		 => 'required|full_name',
		'login_name'	 => 'required|email|unique:users',
		'password'		 => 'required|same:password_confirm',
		'phone_no'		 => 'required|phone_no|unique:users',
		'sex'			 => 'required|sex',
		'speciality'	 => 'required|speciality',
		'enabled'		 => 'required|enabled',
		'user_type'		 => 'required|user_type'
	);

	$validation = Validator::make(Input::all(), $rules);
	if ($validation->fails()) {
		return Redirect::to('users')->withErrors($validation)->withInput();
	}

	$user = new User;
	$user->full_name = Input::get('full_name');
	$user->login_name = Hash::make(Input::get('login_name'));
	$user->password = Hash::make(Input::get('password'));
	$user->phone_no = Input::get('phone_no');
	$user->sex = Input::get('sex');
	$user->speciality = Input::get('speciality');
	$user->enabled = Input::get('enabled');
	$user->user_type = Input::get('admin') ? 1: 0;
	if ($user->save()) {
		Auth::loginUsingId($user->id);
		return Redirect::to('home');	
	}

	return Redirect::to('login')
			->with('message', 'You may now sign in!');

}));

//Route for home page
Route::get('home', function(){
	if (Auth::check()) {
		return View::make('home')->with('user', Auth::user());
	} else {
		return Redirect::to('login')->with('login_error', 'You must login first');
	}
});

//editing user profile
Route::get('profile-edit', function(){
	if (Auth::check()) {
		$user = Input::old() ? (object) Input::old() : Auth::user();
		return View::make('profile-edit')->with('user', $user);
	}
});

//Route to process edit form
Route::post('profile-edit', function(){
	$rules = array(
		'full_name'		 => 'required|full_name',
		'login_name'	 => 'required|email',
		'password'		 => 'required|same:password_confirm',
		'phone_no'		 => 'required|phone_no',
		'sex'			 => 'required',
		'speciality'	 => 'required'
	);

	$validation = Validator::make(Input::all(), $rules);
	if ($validation->fails()) {
		return Redirect::to('profile-edit')->withErrors($validation)->withInput();
	}

	$user = User::find(Auth::user()->id);
	if (Input::get('password')) {
		$user->password = Hash::make(Input::get('password'));
	}
	$user->full_name = Input::get('full_name');
	$user->login_name = Hash::make(Input::get('login_name'));
	$user->phone_no = Input::get('phone_no');
	$user->sex = Input::get('sex');
	$user->speciality = Input::get('speciality');
	if ($user->save()) {
		//Auth::loginUsingId($user->id);
		return Redirect::to('home')->with('notify', 'Information updated');	
	}

	return Redirect::to('profile-edit')->withInput();

});

//To check for user login
Route::post('login', function(){
	$user = DB::table('users')->where('login_name', '=', Input::get('login_name'))->first();
	if (!is_null($user) and Hash::check(Input::get('email'), $user->email) and Hash::check(Input::get('password'), $user->password)) {
		echo "Log in Successfull";
	} else {
		echo "Not able to login";
	}
});

//Login route
Route::get('login', function(){
	return View::make('login');
});

//Route to deal with Cross-Site Request Forgery (CSRF)
Route::get('cross-site', function(){
	return View::make('cross-site');
});

Route::post('cross-site', array('before'=>'csrf', function(){
	echo 'Token' . Session::token() . '<br>';
	dd(Input::all()); //to display results use laravel's dd() helper function
}));

/*Route for dealing with form filters
Route::filter('csrf', function(){
	if (Session::token() != Input::get('_token')) {
		throw new Illuminate\Session\TokenMismatchException;
		
	}
});*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('category/{id}', 'CategoriesController@index');
Route::post('category', 'CategoriesController@create');
Route::post('category', 'CategoriesController@store');
Route::get('category/{id}', 'CategoriesController@show');
Route::delete('category/{id}', 'CategoriesController@destroy');
Route::post('category/{id}', 'CategoriesController@update');