<?php
/**
 * Created by  naveedulhassan
 * Date: 12/1/16
 * Time: 2:32 PM
 */

namespace App\Helpers;


class UserOnlineStatusHandler
{
    /**
     * @var int
     * After this much seconds, the user will be considered inactive
     */
    protected static $expiresAt = 900;
    /**
     * @var
     * e.g. Laravel Auth guard used to differentiate different users e.g. 'admin' / 'user'
     */
    private $guard = "user";
    /**
     * @var
     * stores the 'id' property of the user. So PK must be 'id'
     */
    private $userId;
    /**
     * @var
     * CURRENT_SERVER variable stored in .env to differentiate bw servers in a load balancing system
     */
    private $server;
    /**
     * @var
     * ip of the request
     */
    private $ip;
    /**
     * @var
     * contains whatever is stored in User-Agent header
     */
    private $userAgent;
    /**
     * @var
     * info returned by BrowserDetect (hisorange/browser-detect package)
     */
    private $browserInfo;

    /**
     * UserOnlineStatusHandler constructor.
     * @param null $guard
     */
    public function __construct($guard = null)
    {
        $this->guard = $guard ? $guard : "user";
        $user = $guard ? \Auth::guard($guard)->user() : \Auth::user();
        $user and $this->userId = $user->id;
        $user and $this->email = $user->email;
        $user and $this->name = $user->name;
        $user and $this->photo = $user->photo;
        $this->server = env('CURRENT_SERVER', "default");
        $this->ip = \Request::ip();
        $this->userAgent = \Request::header('User-Agent');
        $this->browserInfo = \Browser::toArray();
        $this->redis = app('redis');
    }

    /**
     * @return string: unique key to be stored in the cache
     * uniqueness is determined by guard, user-id, server, ip and user-agent
     */
    private function key()
    {
        return $this->guard . "-online:" . md5($this->userId . $this->server . $this->ip . $this->userAgent);
    }

    /**
     * @return array: data to be stored in the cache
     * prepares an array of properties
     * used by self::log()
     */
    private function prepData()
    {
        return [
            'userId' => $this->userId,
            'email' => $this->email,
            'name' => $this->name,
            'photo' => $this->photo,
            'server' => $this->server,
            'ip' => $this->ip,
            'lastActiveAt' => time(),
            'guard' => $this->guard,
            'key' => $this->key(),
            'browserInfo' => $this->browserInfo,
        ];
    }

    /**
     * stores the data for the current user in the cache
     * every time it is called, lastActive property is set to current time i.e. time()
     */
    public function log()
    {
        $data = $this->prepData();
        $key = $this->key();

        $this->triggerUserUpdatedEvent();

        $this->redis->set($key, json_encode($data));
        $this->redis->expire($key, static::$expiresAt);
    }

    /**
     * @return array
     * returns all online status entries for current $this->guard
     */
    public function get()
    {
        $keys = $this->redis->keys($this->guard . "-online:*");
        $data = [];
        foreach ($keys as $key) {
            $data[] = json_decode($this->redis->get($key), true);
        }
        return $data;
    }

    /**
     * removes entry from the cache for the current user
     */
    public function remove()
    {
        $this->redis->del($this->key());
        $this->triggerUserRemovedEvent();
    }

    public function triggerUserUpdatedEvent()
    {
        SocketIo::trigger("online-{$this->guard}-updated", $this->prepData());
    }

    public function triggerUserRemovedEvent($key = null)
    {
        SocketIo::trigger("online-{$this->guard}-removed", $this->userId);
    }
}