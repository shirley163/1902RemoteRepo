<?php

header('Content-Type: text');

// 1.实例化对象; obj公认object缩写; API: Application Program Interface缩写
$weChatObj = new WechatAPI();
// 2.调用方法; msg是公认message缩写
$weChatObj->validMsg();

class WechatAPI
{
    /**
     * 验证消息的确来自于微信服务器
     *
     * @return String echostr参数值(校验成功)
     */
    public function validMsg()
    {
        $echostr = $_GET['echostr'];
        if ($this->isCheckSignature()) {
            echo $echostr;
            exit;
        }
    }

    /**
     * 生成加密字符串, 和signature比较, 返回比较结果
     *
     * @return boolean 校验成功, 返回true; 否则返回false
     */
    private function isCheckSignature()
    {
        // 1.获取三个参数(signature, nonce, timestamp)
        $signature = $_GET['signature'];
        $nonce     = $_GET['nonce'];
        $timestamp = $_GET['timestamp'];
        $token     = 'weixin';

        // 2.生成数组(token, nonce, timestamp), 排序
        $arr = [$token, $timestamp, $nonce];
        sort($arr);

        // 3.三个字符串拼接为一个, sha1加密; tmp是temporary(临时)缩写
        $tmpStr = implode($arr);
        $tmpStr = sha1($tmpStr);

        // 4. 加密字符串和signature字符串比对
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}
