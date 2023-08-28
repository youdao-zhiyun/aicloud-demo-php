<?php
function add_auth_params($param, $appKey, $appSecret)
{
    if (array_key_exists('q', $param)) {
        $q = $param['q'];
    } else {
        $q = $param['img'];
    }
    $salt = create_uuid();
    $curtime = strtotime("now");
    $sign = calculate_sign($appKey, $appSecret, $q, $salt, $curtime);
    $param['appKey'] = $appKey;
    $param['salt'] = $salt;
    $param["curtime"] = $curtime;
    $param['signType'] = 'v3';
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

function calculate_sign($appKey, $appSecret, $q, $salt, $curtime)
{
    $strSrc = $appKey . get_input($q) . $salt . $curtime . $appSecret;
    return hash("sha256", $strSrc);
}

function get_input($q)
{
    if (empty($q)) {
        return null;
    }
    $len = mb_strlen($q, 'utf-8');
    return $len <= 20 ? $q : (mb_substr($q, 0, 10) . $len . mb_substr($q, $len - 10, $len));
}

?>
