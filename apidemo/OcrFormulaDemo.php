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
     * 取值参考文档: https://ai.youdao.com/DOCSIRMA/html/ocr/api/ztsbhgs/index.html
     */
    $detectType = "10011";  // 识别类型  10011:识别结果公式完美还原; 10012:识别结果适合搜题;
    $docType = "json";
    $imageType = "1";

    // 数据的base64编码
    $img = read_file_as_base64(PATH);
    $params = array('img' => $img,
        'detectType' => $detectType,
        'docType' => $docType,
        'imageType' => $type,
    );

    $params = add_auth_params($params, APP_KEY, APP_SECRET);
    $r = do_call('https://openapi.youdao.com/ocr_formula', 'post', array(), $params, 'application/json');
    echo $r;
}

function read_file_as_base64($path)
{
    $fp = fopen($path, "rb");
    $data = fread($fp, filesize($path));
    return base64_encode($data);
}

/*
 * 网易有道智云整题识别含公式服务api调用demo
 * api接口: https://openapi.youdao.com/ocr_formula
 */
create_request();
?>
