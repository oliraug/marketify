<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $restful = true;

    /* Catch-all method for requests that can't be matched.
	*
	* @param string $method
	* @param array $parameters
	* @return Response
	*/
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}
}
