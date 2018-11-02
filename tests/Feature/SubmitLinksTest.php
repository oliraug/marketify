<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class SubmitLinksTest extends TestCase
{
    /*
    *The RefreshDatabase makes sure that each test has a new database 
    to give each test a pristine database environment with all the migrations.
    */
    use DatabaseMigrations;

function test_guest_can_submit_a_new_link() {
	$response = $this->post('/submit', [
		'title' => 'A molestiae',
		'url' => 'http://www.olify.com',
		'description' => 'Exposing farmers to markets',
	]);

	$this->assertDatabaseHas('links', [
		'title' => 'A molestiae'
	]);

	$response
            ->assertStatus(302)
            ->assertHeader('Location', url('/'));

        $this
            ->get('/')
            ->assertSee('A molestiae');

}

/** @test */
function test_link_is_not_created_if_validation_fails() {
	$response = $this->post('/submit');
	$response->assertSessionHasErrors(['title', 'url', 'description']);
}

/** @test  Testing URL Validation */
function test_link_is_not_created_with_an_invalid_url() {
	$this->withoutExceptionHandling();

    $cases = ['//invalid-url.com', '/invalid-url', 'foo.com'];

    foreach ($cases as $case) {
        try {
            $response = $this->post('/submit', [
                'title' => 'Example Title',
                'url' => $case,
                'description' => 'Example description',
            ]);
        } catch (ValidationException $e) {
            $this->assertEquals(
                'The url format is invalid.',
                $e->validator->errors()->first('url')
            );
            continue;
        }

        $this->fail("The URL $case passed validation when it should have failed.");
    }
}

/** @test  Testing Max Length Validation */
function test_max_length_fails_when_too_long() {
	$this->withoutExceptionHandling();

    $title = str_repeat('a', 256);
    $description = str_repeat('a', 256);
    $url = 'http://';
    $url .= str_repeat('a', 256 - strlen($url));

    try {
        $this->post('/submit', compact('title', 'url', 'description'));
    } catch(ValidationException $e) {
        $this->assertEquals(
            'The title may not be greater than 255 characters.',
            $e->validator->errors()->first('title')
        );

        $this->assertEquals(
            'The url may not be greater than 255 characters.',
            $e->validator->errors()->first('url')
        );

        $this->assertEquals(
            'The description may not be greater than 255 characters.',
            $e->validator->errors()->first('description')
        );

        return;
    }

    $this->fail('Max length should trigger a ValidationException');

}

/** @test */
function test_max_length_succeeds_when_under_max() {
	$url = 'http://';
    $url .= str_repeat('a', 255 - strlen($url));

    $data = [
        'title' => str_repeat('a', 255),
        'url' => $url,
        'description' => str_repeat('a', 255),
    ];

    $this->post('/submit', $data);

    $this->assertDatabaseHas('links', $data);
	}
}
