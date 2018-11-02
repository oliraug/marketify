<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOlifyCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('olify_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id'); /*Contains our foreign key to the users table*/
            $table->string('category_name', 100)->unique();
            $table->string('category_status', 10);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('olify_categories');
    }
}
