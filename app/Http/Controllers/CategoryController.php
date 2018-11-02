<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Category;
use Response;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    
    protected $categories;
    public function __constructor(Category $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'category_name'      => 'required|string|max:255',
            'category_status'    => 'required|string|max:255',
            'description'        => 'required|string|max:255',
            'user_id'            => 'required|integer',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$category = Category::all();  //Request all categories as objects from Eloguent
        $category = Category::paginate(10); 
        return View::make('categories.index')->with('olify_categories', $categories);
        return $category;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category; //an instance of our Category model
        $category->user_id = Input::get('user_id');  //Input::get() method can be used to retrieve data from the form
        $category->category_name = Input::get('category_name');
        $category->category_status = Input::get('category_status');
        $category->description = Input::get('description');

        $category->save();

        return Redirect::to('categories');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ((!$request->category_name) || (!$request->category_status) || (!$request->description)) {
            $response = Response::json([
                'error' => ['Please enter all required fields.']
            ], 422);
            return $response;
        }
        $category = new Category(array(
            'category_name' => $request->category_name,
            'category_status' => $request->category_status,
            'description' => $request->description
        ));
        $category->save();

        $response = Response::json([
            'message' => 'The category has been created succesfully',
            'data' => $category,
            ], 201);

          return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id); //getting a single category
        if (!$category) {
            $response = Response::json([
                'error' => ['The category cannot be found.']
            ], 404);
            return $response;
        }
        $response = Response::json($category, 200);
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($category_id);

        if (is_null($category)) { 
            return Redirect::to('categories');
        }
        $category->user_id = Input::get('user_id');  //Input::get() method can be used to retrieve data from the form
        $category->category_name = Input::get('category_name');
        $category->category_status = Input::get('category_status');
        $category->description = Input::get('description');

        $category->save();

        return Redirect::to('categories');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ((!$request->category_name) || (!$request->category_status)) {
            $response = Response::json([
                'error' => ['Please enter all required fields.']
            ], 422);
            return $response;
        }
        $category = Category::find($id);
    
        $category->category_name = $request->category_name;
        $category->category_status = $request->category_status;
        $category->description = $request->description;
        
        $category->save();

        $response = Response::json([
            'message' => 'The category has been updated succesfully',
            'data' => $category,
            ], 200);

          return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id); //to verify that a category with the specifed category ID actually exists.

        /* we're checking if our category variable has the null value indicating that the requested category was
        *  not found. If so, we'll redirect back to the categories index.
        */
        if (!$category) { 
            $response = Response::json([
                'error' => ['Category cannot be found.']
            ], 404);
            return $response;
        }
        Category:: destroy();        //we delete the category and redirect back to the categories index.
         $response = Response::json([
            'message' => 'The category has been deleted'
            ], 200);

          return $response;
    }
}
