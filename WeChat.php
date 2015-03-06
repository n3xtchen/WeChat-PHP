<?php
/**
 * Short description for WeChat.php
 *
 * @package WeChat
 * @author n3xtchen <echenwen@gmail.com>
 * @version 0.1
 * @copyright (C) 2014 n3xtchen <echenwen@gmail.com>
 * @license GPL-2.0
 */
namespace WeChat;

use \WeChat\ApiBase;

class WeChat extends ApiBase
{
    private $app_id;
    private $app_secret;
    private $token;
    
    private $curl;
    private $access_token;
    
    public function __construct($config)
    {
        foreach ($config as $k => $v) {
            $this->$k = $v;
        }

        $this->curl = new ApiBase();

        return $this;
    }

    /**
     * 开发者通过检验signature对请求进行校验。
     */
    public function checkSignature()
    {
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce     = $_GET['nonce'];

        $tmp_arr = array($this->token, $timestamp, $nonce);
        sort($tmp_arr, SORT_STRING);
        $tmp_str = implode($tmp_arr);
        $tmp_str = sha1($tmp_str);

        if ($tmp_str == $signature) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 若确认此次GET请求来自微信服务器,并通过签名验证，请原样返回echostr参数内容，
     * 则接入生效，成为开发者成功，否则接入失败。
     */
    public function valiURL()
    {
        if ($this->checkSignature()) {
            return $_GET['echostr'];
        }
    }

    /**
     * 获取 AccessToke
     * @return string
     */
    public function getAccessToken()
    {
        $uri  = 'token';
        $qs   = "?grant_type=client_credential&appid={$this->appID}&secret={$this->appsecret}";
        $resp =  $this->curl($uri.$qs);

        if (in_array('access_token', $resp)) {
            $this->access_token = $resp['access_token'];
        }

        return $resp;
    }
}
