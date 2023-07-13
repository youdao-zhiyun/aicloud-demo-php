<?php
require_once('util/HttpUtil.php');
require_once('util/AuthV3Util.php');
// 您的应用ID
define("APP_KEY", "");
// 您的应用密钥
define("APP_SECRET", "");

// 待识别音频路径, 例windows路径：PATH = "C:\\youdao\\media.wav";
define("PATH", "");

function create_request()
{
    /*
     * note: 将下列变量替换为需要请求的参数
     * 取值参考文档: https://ai.youdao.com/DOCSIRMA/html/tts/api/dyysb/index.html
     */
    $langType = "要识别的语言类型";
    $rate = "采样率 推荐16000";
    $format = "wav";
    $channel = "1";
    $docType = "json";
    $type = "1";

    // 数据的base64编码
    $q = read_file_as_base64(PATH);
    $params = array('q' => $q,
        'langType' => $langType,
        'rate' => $rate,
        'format' => $format,
        'channel' => $channel,
        'docType' => $docType,
        'type' => $type,
    );

    $params = add_auth_params($params, APP_KEY, APP_SECRET);
    $r = do_call('https://openapi.youdao.com/asrapi', 'post', array(), $params, 'application/json');
    echo $r;
}

function read_file_as_base64($path)
{
    $fp = fopen($path, "rb");
    $data = fread($fp, filesize($path));
    return base64_encode($data);
}

/*
 * 网易有道智云语音识别服务api调用demo
 * api接口: https://openapi.youdao.com/asrapi
 */
create_request();
?>
