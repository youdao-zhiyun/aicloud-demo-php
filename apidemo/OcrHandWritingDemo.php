<?php
require_once('util/HttpUtil.php');
require_once('util/AuthV3Util.php');
// 您的应用ID
define("APP_KEY", "");
// 您的应用密钥
define("APP_SECRET", "");

// 待识别图片路径, 例windows路径：PATH = "C:\\youdao\\media.png";
define("PATH", "");

function create_request()
{
    /*
     * note: 将下列变量替换为需要请求的参数
     * 取值参考文档: https://ai.youdao.com/DOCSIRMA/html/ocr/api/sxocr/index.html
     */
    $langType = "语种";  
    $angle = "0";        // 是否支持角度识别 0:否; 1:是;
    $concatLines = "0";  // 是否为行图拼接的图 0:否; 1:是;
    $imageType = "1";
    $docType = "json";

    // 数据的base64编码
    $img = read_file_as_base64(PATH);
    $params = array('img' => $img,
        'langType' => $langType,
        'angle' => $angle,
        'concatLines' => $concatLines,
        'imageType' => $imageType,
        'docType' => $docType,
    );

    $params = add_auth_params($params, APP_KEY, APP_SECRET);
    $r = do_call('https://openapi.youdao.com/ocr_hand_writing', 'post', array(), $params, 'application/json');
    echo $r;
}

function read_file_as_base64($path)
{
    $fp = fopen($path, "rb");
    $data = fread($fp, filesize($path));
    return base64_encode($data);
}

/*
 * 网易有道智云手写体识别服务api调用demo
 * api接口: https://openapi.youdao.com/ocr_hand_writing
 */
create_request();
?>
