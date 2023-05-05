<?php
require_once('util/HttpUtil.php');
require_once('util/AuthV3Util.php');
// 您的应用ID
define("APP_KEY", "");
// 您的应用密钥
define("APP_SECRET", "");

// 合成音频保存路径, 例windows路径：PATH = "C:\\tts\\media.mp3";
define("PATH", "");

function create_request()
{
    /*
     * note: 将下列变量替换为需要请求的参数
     * 取值参考文档: https://ai.youdao.com/DOCSIRMA/html/%E8%AF%AD%E9%9F%B3%E5%90%88%E6%88%90TTS/API%E6%96%87%E6%A1%A3/%E8%AF%AD%E9%9F%B3%E5%90%88%E6%88%90%E6%9C%8D%E5%8A%A1/%E8%AF%AD%E9%9F%B3%E5%90%88%E6%88%90%E6%9C%8D%E5%8A%A1-API%E6%96%87%E6%A1%A3.html
     */
    $q = "待合成文本";
    $langType = "语言类型";
    $voice = "音色编号";
    $format = "mp3";

    $params = array('q' => $q,
        'langType' => $langType,
        'voice' => $voice,
        'format' => $format);
    $params = add_auth_params($params, APP_KEY, APP_SECRET);
    $r = do_call('https://openapi.youdao.com/ttsapi', 'post', array(), $params, 'audio');
    if ($r != null) {
        $file = fopen(PATH, "w");
        fwrite($file, $r);
        fclose($file);
        echo "save file path: " . PATH;
    }
}

/*
 * 网易有道智云语音合成服务api调用demo
 * api接口: https://openapi.youdao.com/ttsapi
 */
create_request();
?>
