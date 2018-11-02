<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserHasManyCategories()
    {
        $this->assertHasMany('categories', 'User');
    }

    public function testDestroyUser()
	{
		Event::shouldReceive('fire')
			->once()
			->with(['cancellation', Mockery::any()]);
		// Perform any other necessary expectations

		$this->call('DELETE', '/users/1');
	 }
}
