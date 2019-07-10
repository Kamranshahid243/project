<?php

namespace App\Helpers\TaskProgressMessages;


use App\Helpers\SocketIo;

class TaskProgress
{
    public static $redisTag = "";

    public static function get($id = null)
    {
        $existing = json_decode(app('redis')->get(static::redisKey($id)), true);
        $existing or $existing = [];
        $completed = app('redis')->get(static::redisKey($id) . ":completed");
        return ['messages' => $existing, 'completed' => $completed];
    }

    public static function delete($id = null)
    {
        app('redis')->del(static::redisKey($id));
        app('redis')->del(static::redisKey($id) . ":completed");
        SocketIo::trigger(static::redisKey($id) . ":completed", $id);
    }

    public static function markAsComplete($id = null)
    {
        app('redis')->set(static::redisKey($id) . ":completed", true);
        SocketIo::trigger(static::redisKey($id) . ":completed", $id);
    }

    public static function addMessage($message, $type = 'info', $id = null)
    {
        $msg = ['msg' => $message, 'time' => date('Y-m-d H:i:s'), 'type' => $type];
        $existing = static::get($id)['messages'];
        $existing[] = $msg;
        app('redis')->set(static::redisKey($id), json_encode($existing));
        app('redis')->del(static::redisKey($id) . ":completed");
        SocketIo::trigger(static::redisKey($id) . ":updated", $msg);
    }

    protected static function redisKey($id = null)
    {
        $key = "task-progress:" . static::$redisTag;
        if ($id) $key .= ":" . $id;
        return $key;
    }
}