<?php
/**
 * Created by PhpStorm.
 * User: imhui
 * Date: 2018/6/14
 * Time: 14:39
 */

namespace App\Controller;


use Illuminate\Database\Capsule\Manager;
use Slim\Http\Request;
use Slim\Http\Response;

class SendController extends Controller
{
	public function SendAction(Request $request, Response $response)
	{
		$params = $request->getQueryParams();
		$res = $this->sendService()->SendApiNotice($params);
		return $response->withJson($res);
	}
}