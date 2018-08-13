<?php
/**
 * Created by PhpStorm.
 * User: imhui
 * Date: 2018/6/14
 * Time: 14:31
 */

namespace App;

//use Elasticsearch\Client as ElasticsearchClient;
//use Illuminate\Database\Capsule\Manager;
use Psr\Log\LoggerInterface;
use Slim\Container;

trait AppDependencyTrait
{
	/**
	 * @return Container | null
	 */
	protected function container()
	{
		return isset($this->container) ? $this->container : null;
	}


	/**
	 * @return LoggerInterface
	 */
	protected function logger()
	{
		return $this->container()->logger;
	}

	/**
	 * @return ElasticsearchClient
	 * @throws \Interop\Container\Exception\ContainerException
	 */
	/*protected function elasticsearch()
	{
		return $this->container()->get('elasticsearch');
	}*/

    /**
     * @return Manager
     * @throws \Interop\Container\Exception\ContainerException
     */
	/*protected function mysql()
    {
        return $this->container()->get('mysql');
    }*/
}