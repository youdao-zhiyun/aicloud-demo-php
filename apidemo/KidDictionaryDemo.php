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
     * 取值参考文档: https://ai.youdao.com/DOCSIRMA/html/dictionary/api/secd/index.html
     */
    $q = "待查询的词";
    $langType = "输入的语言";

    $params = array('q' => $q,
        'langType' => $langType);
    $params = add_auth_params($params, APP_KEY, APP_SECRET);
    $r = do_call('https://openapi.youdao.com/v2/kid_dict', 'post', array(), $params, 'application/json');
    echo $r;
}

/*
 * 网易有道智云少儿词典服务api调用demo
 * api接口: https://openapi.youdao.com/v2/kid_dict
 */
create_request();
?>
