<?php 
    include './class/Util_Aes.class.php'; 
        //此文件为非直接运行的demo,需要根据自己的项目进行整合
	class miBase{
		function __construct (){
		  
		}
			 /*小米感应器自动上传数据*/
        public function miSensorData(){
			
            error_reporting(E_ALL ^ E_DEPRECATED);
            error_reporting(E_ALL ^ E_NOTICE);
            if($_GET) {
		        $result='{"code":0,"message":"ok","result":true}';
	        } else {
                $result='{"code":-9,"message":"unknown error"}';
	        }
		
            if($_GET["data"]&&$_GET["_nonce"])
            {
            $datastr         = $_GET["data"];
            $databin         = base64_decode($datastr);
            $base64nonce     = $_GET["_nonce"];
            $nonce           = base64_decode($base64nonce);
            //填写自己公司的
            $app_secret      ='';
            $sessionSecurity = hash('sha256',$app_secret.$nonce,true);
            $aes             = new \Com\MiSensorHelper\Util_Aes(); //类在class文件夹中，根据自己的环境定义，下同
            $aes->set_key($sessionSecurity);
            $aes->require_pkcs5();
            $decText         = $aes->decrypt($databin);
            $json_array      = json_decode($decText,true);
            $datakey         = array_keys($json_array);
			/**
			  处理数据的逻辑
			**/
			
            //返回数据
            $resultbin  = $aes->encrypt($result);
            $resultdata = base64_encode($resultbin);
			error_log($decText);
            return $resultdata;
			}
        }

        /*查询小米传感器的名称*/
        public function getMiSensorName(){
  
			$aes             = new \Com\MiSensorHelper\Util_Aes();
			$nonce           = "sewrAEWsew";
			$base64nonce     = base64_encode($nonce);
			$app_secret      = ''; //填写自己公司的
			$sessionSecurity = hash('sha256',$app_secret.$nonce,true);
			$base64session   = base64_encode($sessionSecurity);
			$aes->set_key($sessionSecurity);
			$aes->require_pkcs5();
			$databin         = '{"did":"lumi.1111111111"}';   //根据自己的需要进行更改
			$aesdata         = $aes->encrypt($databin);
			$base64databin   = base64_encode($aesdata);
			 
			//获取signature
			$method          = "POST";
			$uri             = "/open/v1/device/getinfo";
			$appkey          = "";//填写自己公司的
			$url             = $method."&".$uri."&app_key=".$appkey."&data=".$base64databin."&".$base64session;
			$sha_url         = sha1($url);
			$signature       = base64_encode($sha_url);

			// 请求参数
			$post_data  = array();
			$action_url = "http://open.aqara.cn".$uri;
			$post_data['data']      = urlencode($base64databin);
			$post_data['signature'] = urlencode($signature);
			$post_data['_nonce']    = urlencode($base64nonce);
			$post_data['app_key']   = $appkey;
			$postDataString = "data=".$post_data['data']."&app_key=".$post_data['app_key']."&signature=".$post_data['signature']."&_nonce=".$post_data['_nonce'];
			//发起POST请求
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $action_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS,$postDataString);
		    curl_setopt($curl, CURLOPT_POST,true);
			$res = curl_exec($curl); $res;
			curl_close($curl);
            $resStr   = base64_decode($res);
            $res_data = json_decode($aes->decrypt($resStr),1);
			return $res_data;
          
        }
      /*添加小米米聊号*/
        public function addMinum(){
			$aes               = new \Com\MiSensorHelper\Util_Aes();
			$nonce        = "sewrAEWsew";
			$base64nonce  = base64_encode($nonce);
			$app_secret      = ''; //换成自己公司的
			$sessionSecurity = hash('sha256',$app_secret.$nonce,true);
			$base64session   = base64_encode($sessionSecurity);
			$aes->set_key($sessionSecurity);
			$aes->require_pkcs5();
			$databin         = '{"minum":"2222222222"}'; //根据自己的业务进行更改
			$aesdata         = $aes->encrypt($databin);
			$base64databin   = base64_encode($aesdata);
			//获取signature
			$method          = "POST";
			$uri             = "/open/v1/user/minum";
			$appkey          = "";//换成自己的
			$url             = $method."&".$uri."&app_key=".$appkey."&data=".$base64databin."&".$base64session;
			$sha_url         = sha1($url);
			$signature       = base64_encode($sha_url);
			$action_url = "http://open.aqara.cn".$uri;
			$postData = array();
			$postData['data']    = urlencode($base64databin);
			$postData['app_key'] = '';//填写自己公司的
			$postData['signature'] = urlencode($signature);
			$postData['_nonce'] = urlencode($base64nonce); ;
			$postDataString = "data=".$postData['data']."&app_key=".$postData['app_key']."&signature=".$postData['signature']."&_nonce=".$postData['_nonce'];
			//发起POST请求
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $action_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS,$postDataString);
		    curl_setopt($curl, CURLOPT_POST,true);
			$res = curl_exec($curl);
			if($res === FALSE ){
			   echo "CURL Error:".curl_error($ch);
			}
			curl_close($curl);
            $resStr   = base64_decode($res);
            $res_data = json_decode($aes->decrypt($resStr),1);
			return $res_data;
        }
	}
	


?>