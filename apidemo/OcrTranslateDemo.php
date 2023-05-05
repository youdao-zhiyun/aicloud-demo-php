<?php
require_once('util/HttpUtil.php');
require_once('util/AuthV3Util.php');
// 您的应用ID
define("APP_KEY", "");
// 您的应用密钥
define("APP_SECRET", "");

// 待翻译图片路径, 例windows路径：PATH = "C:\\youdao\\media.jpg";
define("PATH", "");

function create_request()
{
    /*
     * note: 将下列变量替换为需要请求的参数
     * 取值参考文档: https://ai.youdao.com/DOCSIRMA/html/%E8%87%AA%E7%84%B6%E8%AF%AD%E8%A8%80%E7%BF%BB%E8%AF%91/API%E6%96%87%E6%A1%A3/%E5%9B%BE%E7%89%87%E7%BF%BB%E8%AF%91%E6%9C%8D%E5%8A%A1/%E5%9B%BE%E7%89%87%E7%BF%BB%E8%AF%91%E6%9C%8D%E5%8A%A1-API%E6%96%87%E6%A1%A3.html
     */
    $from = "源语言语种";
    $to = "目标语言语种";
    $render = "是否需要服务端返回渲染的图片";
    $type = "1";

    // 数据的base64编码
    $q = read_file_as_base64(PATH);
    $params = array('q' => $q,
        'from' => $from,
        'to' => $to,
        'render' => $render,
        'type' => $type);

    $params = add_auth_params($params, APP_KEY, APP_SECRET);
    $r = do_call('https://openapi.youdao.com/ocrtransapi', 'post', array(), $params, 'application/json');
    echo $r;
}

function read_file_as_base64($path)
{
    $fp = fopen($path, "rb");
    $data = fread($fp, filesize($path));
    return base64_encode($data);
}

/*
 * 网易有道智云图片翻译服务api调用demo
 * api接口: https://openapi.youdao.com/ocrtransapi
 */
create_request();
?>
