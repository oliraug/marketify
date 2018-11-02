<?php
	
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoriesController extends BaseController
{
    protected $categories;
    public function __constructor(Category $categories)
    {
    	$this->categories = $categories;
    }

    public function get_index()
    {
        $category = Category::all();  //Request all categories as objects from Eloguent
        return View::make('categories.index')->with('olify_categories', $categories);
    }

    public function get_create_category_name()
    {
    	$category = $this->categories->first();
    	return $category->category_name;
    }

    /*
    * Receiving form input and saving it to database
    */
    public function post_create_category()
    {
        $category = new Category; //an instance of our Category model
        $category->user_id = Input::get('user_id');  //Input::get() method can be used to retrieve data from the form
        $category->category_name = Input::get('category_name');
        $category->category_status = Input::get('category_status');
        $category->description = Input::get('description');

        $category->save();

        return Redirect::to('categories');
    }

    /*
    * Retrieving data from the database
    */
    public function get_create_category()
    {
        return View::make('categories.create');
    }

    /*
    * Deleting category records
    */
    public function get_delete_category($category_id)
    {
        $category = Category::find($category_id); //to verify that a category with the specifed category ID actually exists.

        /* we're checking if our category variable has the null value indicating that the requested category was
        *  not found. If so, we'll redirect back to the categories index.
        */
        if (is_null($category)) { 
            return Redirect::to('categories');
        }
        $category->delete();        //we delete the category and redirect back to the categories index.
         return Redirect::to('categories');
    }

    /*
    * Updating category records
    */
    public function get_update_category($category_id)
    {
        $category = Category::find($category_id); //to verify that a category with the specifed category ID actually exists.

        /* we're checking if our category variable has the null value indicating that the requested category was
        *  not found. If so, we'll redirect back to the categories index.
        */
        if (is_null($category)) { 
            return Redirect::to('categories');
        }

        return View::make('categories.update')->with('category', $category);
    }

    public function post_update_category($category_id)
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
}
?>