<?php
/**
 * Created by PhpStorm.
 * User: imhui
 * Date: 2018/6/14
 * Time: 12:37
 */

namespace App\Controller;


use App\AppServiceTrait;
use Slim\Http\Request;
use Slim\Http\Response;


abstract class Controller
{
	use AppServiceTrait;

	protected $container;

	/**
	 * Controller constructor.
	 *
	 * @param $container
	 */
	public function __construct($container)
	{
		$this->container = $container;
	}
}