<?php
Route::get('/show-jobs', function () {
    $keys = app('redis')->keys("queues:*");
    foreach ($keys as $key) {
        $type = app('redis')->type($key);
        if (!in_array($type, ['zset', 'list'])) {
            pr("Unknown key type: {$type}", $key);
            continue;
        }
        $data = $type == 'zset' ? app('redis')->zrange($key, 0, 0) : app('redis')->lrange($key, 0, 0);
        foreach ($data as $index => $datum) {
            $job = json_decode($datum, true);
            $job['data']['command'] = unserialize($job['data']['command']);
            pr($job, "{$key}.{$index}");
        }
    }
});

Route::get('/clear-jobs', function () {
    pr($keys = app('redis')->keys('queues:*'), 'before');
    if ($keys && count($keys)) {
        app('redis')->del($keys);
    }
    pr_exit($keys = app('redis')->keys('queues:*'), 'after');
});

Route::get('/test-mailer', function () {
    Mail::send('emails.test', ['user' => 'Naveed'], function ($m) {
        $m->from('info@schoolpk.com', 'Schoolpk Team');
        $m->to('naveed@schoolpk.com', 'Naveed')->subject('Your Reminder!');
    });
});

Route::get('/test-mailer', function () {
    Mail::send('emails.test', ['user' => 'Naveed'], function ($m) {
        $m->from('info@schoolpk.com', 'Schoolpk Team');
        $m->to('naveed@schoolpk.com', 'Naveed')->subject('Your Reminder!');
    });
});

Route::any('/test-redis', function () {
    $redis = app('redis');
    // show form to delete a key
    echo '<form method="post"><input name="key-to-del"><button>Delete</button></form>';
    if($keyToDel = request('key-to-del')) {
        $redis->del($keyToDel);
        return redirect('/test-redis');
    }

    $query = "*";
    if (request('keys')) {
        $query = request('keys');
    }
    $keys = $redis->keys($query);
    foreach ($keys as $key) {
        if ($redis->type($key) == 'hash') {
            pr($redis->hgetall($key), $key);
        } elseif ($redis->type($key) == 'set') {
            pr($redis->smembers($key), $key);
        } elseif ($redis->type($key) == 'zset') {
            pr($redis->zrange($key, 0, 0), $key);
        } elseif ($redis->type($key) == 'list') {
            pr($redis->lrange($key, 0, 0), $key);
        } else {
            echo $key . ": ";
            echo $redis->get($key);
        }
        echo "<br>ttl: " . $redis->ttl($key) . "<br><hr>";
    }
    exit;
});

/*
 * Lists the routes
 * You can use this list to get info about a specif route
 * and use it e.g. in page_actions table
 * */
Route::get('routes', function () {
    $routeCollection = Route::getRoutes();
    echo "<table style='width:100%'>";
    echo "<tr>";
    echo "<th width='6%'>Method</th>";
    echo "<th width='24%'>Route</th>";
    echo "<th width='70%'>Corresponding Action</th>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        /* @var $value Illuminate\Routing\Route*/
        echo "<tr>";
        echo "<td>" . $value->methods()[0] . "</td>";
        echo "<td>" . $value->uri() . "</td>";
        echo "<td>" . $value->getActionName() . "</td>";
        echo "</tr>";
    }
    echo "</table>";
});