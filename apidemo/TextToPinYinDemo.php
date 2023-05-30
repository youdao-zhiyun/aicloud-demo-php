<?php
require_once('util/HttpUtil.php');
require_once('util/AuthV3Util.php');
// 您的应用ID
define("APP_KEY", "");
// 您的应用密钥
define("APP_SECRET", "");

function create_request()
{
    /*
     * note: 将下列变量替换为需要请求的参数
     */
    $q = "待获取拼音的文本";

    $params = array('q' => $q);
    $params = add_auth_params($params, APP_KEY, APP_SECRET);
    $r = do_call('https://openapi.youdao.com/getPinYin', 'post', array(), $params, 'application/json');
    echo $r;
}

/*
 * 网易有道智云翻译服务api调用demo
 * api接口: https://openapi.youdao.com/api
 */
create_request();
?>
