<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use App\Model\UserModel;
class TestController extends Controller
{
    public function test()
    {
        echo '<pre>';print_r($_SERVER);echo '</pre>';
    }
    /**
     * 用户注册
     */
    public function reg(Request $request)
    {
        echo '<pre>';print_r($request->input());echo '</pre>';
        //验证用户名 验证email 验证手机号
        $pass1 = $request->input('pass1');
        $pass2 = $request->input('pass2');
        if($pass1 != $pass2){
            die("两次输入的密码不一致");
        }
        $password = password_hash($pass1,PASSWORD_BCRYPT);
        $data = [
            'email'         => $request->input('email'),
            'name'          => $request->input('name'),
            'password'      => $password,
            'mobile'        => $request->input('mobile'),
            'last_login'    => time(),
            'last_ip'       => $_SERVER['REMOTE_ADDR'],     //获取远程IP
        ];
         //var_dump($data);
        $uid = UserModel::insertGetId($data);
        var_dump($uid);
    }
    /**
     * 用户登录接口
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        $name = $request->input('name');
        $pass = $request->input('pass');
        $u = UserModel::where(['name'=>$name])->first();
        if($u){
            //验证密码
            if( password_verify($pass,$u->password) ){
                // 登录成功
                //echo '登录成功';
                //生成token
                $token = Str::random(32);
                $response = [
                    'errno' => 0,
                    'msg'   => 'ok',
                    'data'  => [
                        'token' => $token
                    ]
                ];
            }else{
                $response = [
                    'errno' => 400003,
                    'msg'   => '密码不正确'
                ];
            }
        }else{
            $response = [
                'errno' => 400004,
                'msg'   => '用户不存在'
            ];
        }
        return $response;
    }
    /**
     * 获取用户列表
     * 2020年1月2日16:32:07
     */
    public function userList()
    {

            $list=UserModel::all();
            echo '<pre>';print_r($list->toArray());echo '</pre>';

    }

    public function aa()
    { 
        $char='Hello World';
        $length=strlen($char);
        echo $length;echo '</br>';

        $pass="";
        for($i=0;$i<$length;$i++)
        { 
            echo $char[$i] . '>>>' . ord($char[$i]);echo '</br>';
            $ord=ord($char[$i]) -3;
            $chr=chr($ord);
            echo $char[$i]. '>>>' . $ord . '>>>' .$chr;echo '<hr>';      
            //$str .=$chr;

       }
        echo "解密： ".$chr;
      }

      //解密
      public function dec()
      { 

        $enc='Khoor#Zruog';
        echo "密文:".$enc;echo '<hr>';
        $length=strlen($enc);

        for($i=0;$i<$length;$i++)
        { 
            $ord=ord($enc[$i]);
            $chr=chr($ord);
            echo $ord . '>>>' . $chr;echo '</br>';
        }

      }

      public function req()
      { 
        echo '<pre>';print_r($_GET);echo '</pre>';
      }

    public function jm()
    {
        $data=$_GET['data'];
        echo "原文:".$data;echo "</br>";
        $method="AES-256-CBC";
        $key="1905_week";
        $iv="abcdefghigklmnop";
        $enc_data=openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
        $enc_data=base64_encode($enc_data);
        echo "加密后密文:".$enc_data;"</br>";
        echo "<hr>";
        echo "解密:";echo "</br>";
        $enc_data=base64_decode($enc_data);
        $dec_data=openssl_decrypt($enc_data,$method,$key,OPENSSL_RAW_DATA,$iv);
        echo $dec_data;
    }
    /**
     * 解密
     * @return [type] [description]
     */
    public function jim()
    {
        $data=$_GET['data'];
        echo "原文:".$data;echo "</br>";
        $method="AES-256-CBC";
        $key="1905_week";
        $iv="abcdefghigklmnop";
        echo "解密:";echo "</br>";
        $enc_data=base64_decode($data);
        $dec_data=openssl_decrypt($enc_data,$method,$key,OPENSSL_RAW_DATA,$iv);
        echo $dec_data;
    }

     /**
     * 使用私钥对数据加密
     */
    public function jiami()
    {
        $priv_key=file_get_contents(storage_path("keys/priv.key"));
        $data="hello worldssss";
        echo "</br>";
        echo "待加密数据:" .$data;echo "</br>";
        openssl_private_encrypt($data, $enc_data, $priv_key);
        echo $enc_data;
        $base64_encode_str=base64_encode($enc_data);
        echo "</br>";
        echo $base64_encode_str;
        $url="http://www.wechat.com/api/jim?data=".urlencode($base64_encode_str);
        echo "<hr>";
        file_get_contents($url);
    }

    /**
     * Curl get
     */
    public function curl1()
    {
        $url="http://1905api.comcto.com/test/curl1?x=1&y=2&z=3";
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_exec($ch);
        curl_close($ch);
    }
    /**
     * POST传值（form-data）    
     */
    public function curl2()
    {
        $url="http://1905api.comcto.com/test/curl2";
        $data=[
            "x"=>1,
            "y"=>2,
            "z"=>3
        ];
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_exec($ch);
        curl_close($ch);
    }
    /**
     * POST上传文件 
     */
    public function curl3()
    {
        $data=request()->all();
        $url="http://1905api.comcto.com/test/curl3";
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_exec($ch);
        curl_close($ch);
    }
    /**
     * POST发送json
     */
    public function curl4()
    {
        $url="http://1905api.comcto.com/test/curl4";
        $token ="23456789";
        $data=[
            "x"=>1,
            "y"=>2,
            "z"=>3
        ];
        $json_str=json_encode($data);
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$json_str);
        curl_setopt($ch,CURLOPT_HTTPHEADER,[
            "Content-Type:text/plain",
            "token:".$token
            ]);
        curl_exec($ch);
        curl_close($ch);
    }

    public function decrypt()
    {
        $data=$_GET['data'];
        echo "原文:".$data;echo "</br>";
        $data=base64_decode($data);
        echo "base64_decode:".$data;echo "</br>";
        $method="AES-256-CBC";
        $key="1905api";
        $iv="1234567891234567";
        $dec_data=openssl_decrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
        echo "解密数据:". $dec_data;
    }
    /**
     * 解密
     */
    public function pubDecrypt()
    {
        $data=$_GET['data'];
        echo "接收到的base64的数据:".$data;
        $pub_key=file_get_contents(storage_path("keys/pub.key"));
        $base64_decode=base64_decode($data);
        echo  $base64_decode;
        openssl_public_decrypt($base64_decode,$dec_data,$pub_key);
        echo "解密数据:". $dec_data;
    }
















}