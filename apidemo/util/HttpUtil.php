<?php
function do_call($url, $method, $header, $param, $expectContentType, $timeout = 3000)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    if (!empty($header)) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    }
    $data = http_build_query($param);
    if ($method == 'post') {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    } else if ($method == 'get') {
        $url = $url . '?' . $data;
    } else {
        print 'http method not support';
        return null;
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    $r = curl_exec($curl);
    $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
    if (strpos($contentType, $expectContentType) === false) {
        echo $r;
        $r = null;
    }
    curl_close($curl);
    return $r;
}
?>