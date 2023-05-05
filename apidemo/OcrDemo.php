<?php
require_once('util/HttpUtil.php');
require_once('util/AuthV3Util.php');
// 您的应用ID
define("APP_KEY", "");
// 您的应用密钥
define("APP_SECRET", "");

// 待识别图片路径, 例windows路径：PATH = "C:\\youdao\\media.jpg";
define("PATH", "");

function create_request()
{
    /*
     * note: 将下列变量替换为需要请求的参数
     * 取值参考文档: https://ai.youdao.com/DOCSIRMA/html/%E6%96%87%E5%AD%97%E8%AF%86%E5%88%ABOCR/API%E6%96%87%E6%A1%A3/%E9%80%9A%E7%94%A8%E6%96%87%E5%AD%97%E8%AF%86%E5%88%AB%E6%9C%8D%E5%8A%A1/%E9%80%9A%E7%94%A8%E6%96%87%E5%AD%97%E8%AF%86%E5%88%AB%E6%9C%8D%E5%8A%A1-API%E6%96%87%E6%A1%A3.html
     */
    $langType = "要识别的语言类型";
    $detectType = "识别类型";
    $angle = "是否进行360角度识别";
    $column = "是否按多列识别";
    $rotate = "是否需要获得文字旋转角度";
    $docType = "json";
    $imageType = "1";

    // 数据的base64编码
    $img = read_file_as_base64(PATH);
    $params = array('img' => $img,
        'langType' => $langType,
        'detectType' => $detectType,
        'angle' => $angle,
        'column' => $column,
        'rotate' => $rotate,
        'docType' => $docType,
        'imageType' => $imageType,
    );

    $params = add_auth_params($params, APP_KEY, APP_SECRET);
    $r = do_call('https://openapi.youdao.com/ocrapi', 'post', array(), $params, 'application/json');
    echo $r;
}

function read_file_as_base64($path)
{
    $fp = fopen($path, "rb");
    $data = fread($fp, filesize($path));
    return base64_encode($data);
}

/*
 * 网易有道智云通用OCR服务api调用demo
 * api接口: https://openapi.youdao.com/ocrapi
 */
create_request();
?>
