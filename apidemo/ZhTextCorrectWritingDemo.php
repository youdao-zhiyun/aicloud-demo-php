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
     * 取值参考文档: https://ai.youdao.com/DOCSIRMA/html/%E4%BD%9C%E6%96%87%E6%89%B9%E6%94%B9/API%E6%96%87%E6%A1%A3/%E4%B8%AD%E6%96%87%E4%BD%9C%E6%96%87%E6%89%B9%E6%94%B9%EF%BC%88%E6%96%87%E6%9C%AC%E8%BE%93%E5%85%A5%EF%BC%89/%E4%B8%AD%E6%96%87%E4%BD%9C%E6%96%87%E6%89%B9%E6%94%B9%EF%BC%88%E6%96%87%E6%9C%AC%E8%BE%93%E5%85%A5%EF%BC%89-API%E6%96%87%E6%A1%A3.html
     */
    $q = "正文文本";
    $grade = "作文等级";
    $title = "作文标题";
    $requirement = "题目要求";

    $params = array('q' => $q,
        'grade' => $grade,
        'title' => $title,
        'requirement' => $requirement);
    $params = add_auth_params($params, APP_KEY, APP_SECRET);
    $r = do_call('https://openapi.youdao.com/correct_writing_cn_text', 'post', array(), $params, 'application/json');
    echo $r;
}

/*
 * 网易有道智云中文作文批改服务api调用demo
 * api接口: https://openapi.youdao.com/correct_writing_cn_text
 */
create_request();
?>
