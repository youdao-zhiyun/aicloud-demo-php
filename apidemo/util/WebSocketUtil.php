<?php

use React\Promise\Deferred;
use WebSocket\Client;

require_once('vendor/autoload.php');

// composer require textalk/websocket
// composer require react/promise
function init_connection($url)
{
    $client = new Client($url, ['filter' => ['text', 'binary', 'close'],
        'return_obj' => true]);
    $deferred = new Deferred();
    $asyncTask = function () use ($client, $deferred) {
        try {
            message_handler($client);
        } catch (Exception $e) {
            $deferred->reject($e);
        }
    };
    $loop = React\EventLoop\Loop::get();
    $loop->futureTick($asyncTask);
    return $client;
}

function init_connection_with_params($url, $params)
{
    $data = http_build_query($params);
    return init_connection($url . "?" . $data);
}

function send_text_message($client, $message)
{
    $client->text($message);
    echo 'send text message: ' . $message . "\n";
}

function send_binary_message($client, $message)
{
    $binary = pack("H*", bin2hex($message));
    $client->binary($binary);
    echo 'send binary message length: ' . strlen($binary) . "\n";
}

function message_handler($client)
{
    while (true) {
        try {
            $message = $client->receive();
            $opcode = $message->getOpcode();
            if ($opcode == 'text') {
                $text = $message->getContent();
                echo "received text message: " . $text . "\n";
                if (!strpos($text, "\"errorCode\":\"0\"")) {
                    // 退出程序
                    exit();
                }
            } else if ($opcode == 'binary') {
                $binary = $message->getContent();
                echo "received binary message length: " . count($binary) . "\n";
            } else if ($opcode == 'close') {
                echo "connect closed\n";
                // 退出程序
                exit();
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
}

?>
