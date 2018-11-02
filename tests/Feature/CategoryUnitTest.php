<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Category;
use App\Olify\Marketify\Repositories\CarouselRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

use Faker\Factory as Faker;

class CategoryUnitTest extends TestCase
{
    use DatabaseTransactions;
    //use DatabaseMigrations //for resetting database after each test
    /**
     * A basic test example.
     *
     * @return void
     */
    public function setUp(){
    	parent::setUp();
    	//factory(Category::class)->create();
    	Artisan::call('migrate:refresh');
    	$this->seed();
    }

    public function test_it_can_create_a_category()
    {   
    	// Create a single App\Category instance...
    	$category = factory(Category::class)->create([
            'category_name' => 'Vegetables',
            'category_status' => 'active',
            'description' => 'Vegetable dealers'
        ]);
        // Create three App\Category instance...
        $categories = factory(App\User::class, 3)->create();
    	//$faker = Faker::create();
    	//Arrange
    	$data = [
				'category_name' 		=> $this->$faker->category_name,
				"category_status"		=> $this->$faker->category_status,
				"description" 			=> $this->$faker->description,
			];
			//Act
			
			$categoryRepo = new CategoryRepository(new Category);
			$category = $categoryRepo->createCategory($data);

			//Assert

			$this->assertInstanceOf(Category::class, $category);
			$this->assertEquals($data['category_name'], $category->category_name);
			$this->assertEquals($data['category_status'], $category->category_status);
			$this->assertEquals($data['description'], $category->description);
			$this->assertEquals($data['created_date'], $category->created_date);
			$this->assertEquals($data['updated_date'], $category->updated_date);	
			$this->assertTrue(true);

			$response = $this->actingAs($category, 'api')->json('POST', '/api/categories',$data);
            $response->assertStatus(200);
            $response->assertJson(['status' => true]);
            $response->assertJson(['message' => "Category Created!"]);
            $response->assertJson(['data' => $data]);
    }

    /*public function test_it_can_show_a_category()
    {
    	//$category = factory(Category::class)->create();
    	$categoryRepo = new CategoryRepository(new Category);
    	$found = $categoryRepo->findCategory($category->category_id);

    	$this->assertInstanceOf(Category::class, $found);
			$this->assertEquals($found->category_name, $category->category_name);
			$this->assertEquals($found->category_status, $category->category_status);
			$this->assertEquals($found->description, $category->description);
			$this->assertEquals($found->created_date, $category->created_date);
			$this->assertEquals($found->updated_date, $category->updated_date);
			$response = $this->call('GET', 'categories');
      $this->assertResponseOk();
      $this->assertEquals('List of Product categories', $response->getContent());	

    }

    public function test_it_can_update_a_category()
    {   
    	
    	$category = factory(Category::class)->create();
    	//Arrange
    	$data = [
				'category_name' 		=> $this->$faker->category_name,
				"category_status"		=> $this->$faker->category_status,
				"description" 			=> $this->$faker->description,
				"created_date" 			=> $this->$faker->created_date,
				"updated_date" 			=> $this->$faker->updated_date,
			];
			//Act
			$categoryRepo = new CategoryRepository($category);
			$update = $categoryRepo->updateCategory($data);

			//Assert
			$this->assertTrue(true);
			$this->assertEquals($data['category_name'], $category->category_name);
			$this->assertEquals($data['category_status'], $category->category_status);
			$this->assertEquals($data['description'], $category->description);
			$this->assertEquals($data['created_date'], $category->created_date);
			$this->assertEquals($data['updated_date'], $category->updated_date);			
    }


    /** @test *
    public function test_it_can_delete_the_category()
    {
        $category = factory(Category::class)->create();
      
        $categoryRepo = new CategoryRepository($category);
        $delete = $categoryRepo->deleteCategory();
        
        $this->assertTrue($delete);
    }

    public function test_create_category_with_middleware()
    {
    	 //Arrange
    	$data = [
				'category_name' 		=> "Vegetables",
				"category_status"		=> "active",
				"description" 			=> "Specialist in buying and selling of Vegetables",
				"created_date" 			=> "now()",
				"updated_date" 			=> "now()",
			];

			$response = $this->json('POST', 'api/categories', $data);
			$response->assertStatus(401);
			$response->assertJson(['message' => 'Unauthenticated.']);
    }*/

    public function testBasicTest()
    {
        $response = $this->get('/olify_category');
        //$response->assertSee('Vegetables are delicious'); for testing html contents

        $response->assertStatus(404);
    }

    public function test_category_retrieval()
    {
            // Given a category has been created in the database
        $insertedcategory = factory(Category::class)->create();
        
        // When I fetch the latest categories
        $retrievedcategory = Category::latest()->get();
        
        // Then I should have a correct response of 1 category
        // Inserted category should match first result of latest() method call (retrieved category)
        $this->assertEquals($insertedcategory->toArray(), $retrievedcategory[0]->toArray());
    }

    //test interacting with html forms
    public function test_new_category_registration()
    {
        $this->visit('/olify_category')
             ->type('Vegetables', 'category_name')
             ->select('category_status')
             ->type('description')
             ->press('Add')
             ->seePageIs('dashboard');
    }
}
