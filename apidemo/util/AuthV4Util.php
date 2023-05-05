<?php
function add_auth_params($param, $appKey, $appSecret)
{
    $salt = create_uuid();
    $curtime = strtotime("now");
    $sign = calculate_sign($appKey, $appSecret, $salt, $curtime);
    $param['appKey'] = $appKey;
    $param['salt'] = $salt;
    $param["curtime"] = $curtime;
    $param['signType'] = 'v4';
    $param['sign'] = $sign;
    return $param;
}

function create_uuid()
{
    $str = md5(uniqid(mt_rand(), true));
    $uuid = substr($str, 0, 8) . '-';
    $uuid .= substr($str, 8, 4) . '-';
    $uuid .= substr($str, 12, 4) . '-';
    $uuid .= substr($str, 16, 4) . '-';
    $uuid .= substr($str, 20, 12);
    return $uuid;
}

function calculate_sign($appKey, $appSecret, $salt, $curtime)
{
    $strSrc = $appKey . $salt . $curtime . $appSecret;
    return hash("sha256", $strSrc);
}

?>
