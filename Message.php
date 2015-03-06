<?php
/**
 * Short description for MsgParser.php
 *
 * @package Message
 * @author n3xtchen <echenwen@gmail.com>
 * @version 0.1
 * @copyright (C) 2014 n3xtchen <echenwen@gmail.com>
 * @license GPL-2.0
 */
namespace WeChat;

use \WeChat\ApiBase;

class Message
{

    private $data;

    /**
     * 解析 XML
     * @param $xml_str, String
     */
    public function __construct($xml_str)
    {
        $this->data = simplexml_load_string($xml_str, null, LIBXML_NOCDATA);
        
        return $this;
    }





}
