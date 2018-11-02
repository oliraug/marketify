<?php
	
	namespace Tests\Unit\Marketify;

	use App\Olify\Marketify\Category;
  use App\Olify\Marketify\Repositories\CarouselRepository;
	use Tests\TestCase;

	/**
	 * Unit testing a category class
	 */
	class CategoryUnitTest extends TestCase
	{
		//@test
		public function it_can_create_a_category()
		{
			$data = [
				"category_name" 		=> $this->faker->word,
				"category_status"		=> $this->faker->word,
				"description" 			=> $this->faker->word,
			];

			$categoryRepo = new CategoryRepository(new Category);
			$category = $categoryRepo->createCategory($data);

			$this->assertInstanceOf(Category::class, $category);
			$this->assertEquals($data['category_name'], $category->category_name);
			$this->assertEquals($data['category_status'], $category->category_status);
			$this->assertEquals($data['description'], $category->description);
		}
	}


?>