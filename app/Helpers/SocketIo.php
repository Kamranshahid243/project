<?php
/**
 * Created by Naveed
 * Date: 10/13/2017
 * Time: 4:38 PM
 */

namespace App\Helpers;

class SocketIo
{
    public static function trigger($event, $data)
    {
        $redisChannel = env('SOCKET_IO_CHANNEL', 'socket-io-nvd');
        app('redis')->publish($redisChannel, json_encode([
            'event' => $event,
            'data' => $data
        ]));
    }
}