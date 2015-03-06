<?php
/**
 * Short description for ApiBase.php
 *
 * @package ApiBase
 * @author n3xtchen <echenwen@gmail.com>
 * @version 0.1
 * @copyright (C) 2014 n3xtchen <echenwen@gmail.com>
 * @license GPL-2.0
 */
namespace WeChat;

class ApiBase
{
    const VERSION = 'v';
    const WECHAT_API = 'https://api.weixin.qq.com/cgi-bin/';

    protected $curl_opts = [
        // 设置header
        CURLOPT_HEADER         => 0,
        CURLOPT_HTTPHEADER     => ['Accept: application/json'],
        CURLOPT_RETURNTRANSFER => 1 // 要求结果保存到字符串中
    ];

    /**
     * 将数组转化成 QueryString
     *
     */
    public static function arr2qs($data)
    {
        $qs = '';
        if (!empty($data)) {
            $qd = [];

            foreach ($data as $k => $v) {
                $qd[] = $k.'='.urlencode($v);
            }

            $qs = implode('&', $qd);
        }

        return $qs;
    }

    public function curl($uri, $method = 'GET', $data = [])
    {
        // 将数组转化成 QueryString
        $query_string = $this->arr2qs($data);

        // 初始化一个 cURL 对象
        $curl = curl_init();

        // 设置参数
        $opts = $this->curl_opts;
        $opts[CURLOPT_CUSTOMREQUEST] = $method;
        $opts[CURLOPT_URL] = self::WECHAT_API.$uri;

        curl_setopt_array($curl, $opts);

        // 设置传送的参数
        if (in_array($method, ['PUT', 'POST'])) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $query_string);
        }

        // 运行cURL，请求网页
        $data = curl_exec($curl);

        // 关闭URL请求
        curl_close($curl);

        return JSON_DECODE($data, 1);
    }
}
