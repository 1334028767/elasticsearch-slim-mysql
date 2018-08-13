<?php
/**
 * Created by PhpStorm.
 * User: imhui
 * Date: 2018/6/14
 * Time: 14:03
 */

namespace App\Service;


use Elasticsearch\Client as ElasticsearchClient;

class SendService
{
	/**
	 * @var ElasticsearchClient
	 */
	private $esClient;

	private $url="";

	/**
	 * StatsService constructor.
	 *
	 * @param ElasticsearchClient $esClient
	 */
	public function __construct(ElasticsearchClient $esClient)
	{
		$this->esClient = $esClient;
	}

	public function get($id)
	{
		return $id;
	}

	public function insert($data)
	{
		echo $data;
	}

	public function sendNotice()
    {
        $data = file_get_contents($this->url);
        if (!empty($data)) {
            $res = $this->request_post("https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send",$data);
            return $res;
        }
    }

    public function SendApiNotice($params)
    {
        $json = '{
          "touser": "'.$params['openid'].'",
          "template_id": "'.$params['template_id'].'",
          "page": "'.$params['page'].'",
          "form_id": "'.$params['form_id'].'",
          "data": '.$params['data'].',
          "emphasis_keyword": "'.$params['data'].'"
        }';
        $res = $this->request_post("https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send",$json);
        return $res;
    }

    public function request_post($url = '', $param = '', $type) {
        if (empty($url) || empty($param)) {
            return false;
        }
        if($type=='json'){//json $_POST=json_decode(file_get_contents('php://input'), TRUE);
            $headers = array("Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache");
        }
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }
}