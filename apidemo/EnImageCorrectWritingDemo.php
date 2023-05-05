<?php
require_once('util/HttpUtil.php');
require_once('util/AuthV3Util.php');
// 您的应用ID
define("APP_KEY", "");
// 您的应用密钥
define("APP_SECRET", "");

// 作文图片路径, 例windows路径：PATH = "C:\\youdao\\media.jpg";
define("PATH", "");

function create_request()
{
    /*
     * note: 将下列变量替换为需要请求的参数
     * 取值参考文档: https://ai.youdao.com/DOCSIRMA/html/%E4%BD%9C%E6%96%87%E6%89%B9%E6%94%B9/API%E6%96%87%E6%A1%A3/%E8%8B%B1%E8%AF%AD%E4%BD%9C%E6%96%87%E6%89%B9%E6%94%B9%EF%BC%88%E6%96%87%E6%9C%AC%E8%BE%93%E5%85%A5%EF%BC%89/%E8%8B%B1%E8%AF%AD%E4%BD%9C%E6%96%87%E6%89%B9%E6%94%B9%EF%BC%88%E6%96%87%E6%9C%AC%E8%BE%93%E5%85%A5%EF%BC%89-API%E6%96%87%E6%A1%A3.html
     */
    $grade = "作文等级";
    $title = "作文标题";
    $modelContent = "作文参考范文";
    $isNeedSynonyms = "是否查询同义词";
    $correctVersion = "作文批改版本：基础，高级";
    $isNeedEssayReport = "是否返回写作报告";

    // 数据的base64编码
    $q = read_file_as_base64(PATH);
    $params = array('q' => $q,
        'grade' => $grade,
        'title' => $title,
        'modelContent' => $modelContent,
        'isNeedSynonyms' => $isNeedSynonyms,
        'correctVersion' => $correctVersion,
        'isNeedEssayReport' => $isNeedEssayReport);
    $params = add_auth_params($params, APP_KEY, APP_SECRET);
    $r = do_call('https://openapi.youdao.com/v2/correct_writing_image', 'post', array(), $params, 'application/json');
    echo $r;
}

/*
 * 网易有道智云英文图片作文批改服务api调用demo
 * api接口: https://openapi.youdao.com/v2/correct_writing_image
 */
create_request();
?>
