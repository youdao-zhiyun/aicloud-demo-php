<?php
require_once('util/WebSocketUtil.php');
require_once('util/AuthV4Util.php');
// 您的应用ID
define("APP_KEY", "");
// 您的应用密钥
define("APP_SECRET", "");
// 识别音频路径, 例windows路径：PATH = "C:\\youdao\\media.wav";
define("PATH", "");

function create_request()
{
    /*
     * note: 将下列变量替换为需要请求的参数
     * 取值参考文档: https://ai.youdao.com/DOCSIRMA/html/%E5%AE%9E%E6%97%B6%E8%AF%AD%E9%9F%B3%E7%BF%BB%E8%AF%91/API%E6%96%87%E6%A1%A3/%E5%AE%9E%E6%97%B6%E8%AF%AD%E9%9F%B3%E7%BF%BB%E8%AF%91%E6%9C%8D%E5%8A%A1/%E5%AE%9E%E6%97%B6%E8%AF%AD%E9%9F%B3%E7%BF%BB%E8%AF%91%E6%9C%8D%E5%8A%A1-API%E6%96%87%E6%A1%A3.html
     */
    $from = "源语言语种";
    $to = "目标语言语种";
    $rate = "音频数据采样率, 推荐16000";
    $format = "音频格式, 推荐wav";

    $params = array('from' => $from,
        'to' => $to,
        'rate' => $rate,
        'format' => $format,
        'channel' => "1",
        'version' => "v1");
    $params = add_auth_params($params, APP_KEY, APP_SECRET);
    // 初始化websocket连接
    $con = init_connection_with_params('wss://openapi.youdao.com/stream_speech_trans', $params);
    // 模拟发送流式数据
    send_data($con, PATH, 6400);
}

function send_data($client, $path, $step)
{
    if (!file_exists($path)) {
        echo "file not exist";
        return;
    }
    $file = fopen($path, "r");
    // 发送消息的时间
    $pre_timestamp = return_mills_timestamp();
    while (!feof($file)) {
        $cur_timestamp = return_mills_timestamp();
        // 流式数据传输间隔推荐每6400bytes间隔200ms
        if ($cur_timestamp - $pre_timestamp < 200) {
            continue;
        }
        $pre_timestamp = $cur_timestamp;
        $buffer = fread($file, $step);
        send_binary_message($client, $buffer);
    }
    send_binary_message($client, "{\"end\": \"true\"}");
}

// 获取毫秒级时间戳
function return_mills_timestamp()
{
    $microtime = microtime(true);
    return round($microtime * 1000);
}

/*
 * 网易有道智云流式语音翻译服务api调用demo
 * api接口: wss://openapi.youdao.com/stream_speech_trans
 */
create_request();
?>
