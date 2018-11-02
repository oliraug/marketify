<?php

namespace App\Olify\Marketify;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factory;

class Category extends Model
{
    protected $primaryKey = 'category_id';
    protected $table = 'olify_category';

    protected $fillable = array(
    		'user_id', /*Contains our foreign key to the users table*/
    		'category_name',
    		'category_status',
    		'description',
    		'created_at_ip',
    		'updated_at_ip'
    );

    //Define relationships, each market user has many product categories
    public function user()
    {
    	return $this->hasMany('User');
    }
}
