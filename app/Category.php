<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'olify_category';

    protected $fillable = array(
    		'user_id', /*Contains our foreign key to the users table*/
    		'category_name',
    		'category_status',
    		'description'
    );

    //Define relationships, each market user has many product categories
    public function user()
    {
    	return $this->hasMany('User');
    }
}
