<?php
require_once('util/HttpUtil.php');
require_once('util/AuthV3Util.php');
// 您的应用ID
define("APP_KEY", "");
// 您的应用密钥
define("APP_SECRET", "");

// 待翻译语音路径, 例windows路径：PATH = "C:\\youdao\\media.wav";
define("PATH", "");

function create_request()
{
    /*
     * note: 将下列变量替换为需要请求的参数
     * 取值参考文档: https://ai.youdao.com/DOCSIRMA/html/%E8%87%AA%E7%84%B6%E8%AF%AD%E8%A8%80%E7%BF%BB%E8%AF%91/API%E6%96%87%E6%A1%A3/%E8%AF%AD%E9%9F%B3%E7%BF%BB%E8%AF%91%E6%9C%8D%E5%8A%A1/%E8%AF%AD%E9%9F%B3%E7%BF%BB%E8%AF%91%E6%9C%8D%E5%8A%A1-API%E6%96%87%E6%A1%A3.html
     */
    $from = "源语言语种";
    $to = "目标语言语种";
    $format = "音频格式, 推荐wav";
    $rate = "音频数据采样率, 推荐16000";

    // 数据的base64编码
    $q = read_file_as_base64(PATH);
    $params = array('q' => $q,
        'from' => $from,
        'to' => $to,
        'format' => $format,
        'rate' => $rate,
        'channel' => "1",
        'type' => "1");

    $params = add_auth_params($params, APP_KEY, APP_SECRET);
    $r = do_call('https://openapi.youdao.com/speechtransapi', 'post', array(), $params, 'application/json');
    echo $r;
}

function read_file_as_base64($path)
{
    $fp = fopen($path, "rb");
    $data = fread($fp, filesize($path));
    return base64_encode($data);
}

/*
 * 网易有道智云语音翻译服务api调用demo
 * api接口: https://openapi.youdao.com/speechtransapi
 */
create_request();
?>
