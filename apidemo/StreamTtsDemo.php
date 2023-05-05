<?php
require_once('util/WebSocketUtil.php');
require_once('util/AuthV4Util.php');
// 您的应用ID
define("APP_KEY", "");
// 您的应用密钥
define("APP_SECRET", "");

// 语音合成文本
define("TEXT", "语音合成文本");

function create_request()
{
    /*
     * note: 将下列变量替换为需要请求的参数
     */
    $langType = "语言类型";
    $voice = "发言人";
    $rate = "音频数据采样率";
    $format = "音频格式";
    $volume = "音量, 取值0.1-5";
    $speed = "语速, 取值0.5-2";

    $params = array('langType' => $langType,
        'voice' => $voice,
        'rate' => $rate,
        'format' => $format,
        'volume' => $volume,
        'speed' => $speed);
    $params = add_auth_params($params, APP_KEY, APP_SECRET);
    // 初始化websocket连接
    $con = init_connection_with_params('wss://openapi.youdao.com/stream_tts', $params);
    // 模拟发送流式数据
    send_data($con);
}

function send_data($client)
{
    send_text_message($client, sprintf("{\"text\":\"%s\"}", TEXT));
    send_binary_message($client, "{\"end\": \"true\"}");
}

/*
 * 网易有道智云流式语音合成服务api调用demo
 * api接口: wss://openapi.youdao.com/stream_tts
 */
create_request();
?>
