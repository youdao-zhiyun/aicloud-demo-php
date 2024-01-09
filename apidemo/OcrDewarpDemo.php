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
     * 取值参考文档: https://ai.youdao.com/DOCSIRMA/html/ocr/api/txjz/index.html
     */
    // 是否进行图像增强预处理
    $enhance = "0";
    // 是否进行360角度识别
    $angle = "0";
    // 是否进行图像检测
    $docDetect = "1";
    // 是否进行图像矫正,同时将自动跳过轮廓分割
    $docDewarp = "1";

    // 数据的base64编码
    $q = read_file_as_base64(PATH);
    $params = array('q' => $q,
        'enhance' => $enhance,
        'angle' => $angle,
        'docDetect' => $docDetect,
        'docDewarp' => $docDewarp,
    );

    $params = add_auth_params($params, APP_KEY, APP_SECRET);
    $r = do_call('https://openapi.youdao.com/ocr_dewarp', 'post', array(), $params, 'application/json');
    echo $r;
}

function read_file_as_base64($path)
{
    $fp = fopen($path, "rb");
    $data = fread($fp, filesize($path));
    return base64_encode($data);
}

/*
 * 网易有道智云图像矫正服务api调用demo
 * api接口: https://openapi.youdao.com/ocr_dewarp
 */
create_request();
?>
