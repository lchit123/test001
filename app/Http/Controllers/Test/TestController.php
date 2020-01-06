<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
   public function xmlTest()
    {
        $xml_str = '<xml><ToUserName><![CDATA[gh_1fa6cdd0fa98]]></ToUserName>
<FromUserName><![CDATA[oL9TIv4b2SPVu10NwRovMVTu9qVk]]></FromUserName>
<CreateTime>1576810924</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[aaa]]></Content>
<MsgId>22574506690640278</MsgId>';
        $xml_obj = simplexml_load_string($xml_str);
        echo '<pre>';print_r($xml_obj);echo '</pre>';die;
        echo '<pre>';print_r($xml_obj);echo '</pre>';echo '<hr>';
        echo 'ToUserName: '. $xml_obj->ToUserName;echo '</br>';
        echo 'FromUserName: '.$xml_obj->FromUserName;echo '</br>';
    }
}
