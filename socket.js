var server = require('http').Server();
var socket = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();
require('dotenv').config();

var redisChannel = process.env.SOCKET_IO_CHANNEL || 'socket-io-nvd';

redis.subscribe(redisChannel);
redis.on('message', function (channel, message) {
    message = JSON.parse(message);
    socket.emit(message.event, message.data);
    console.log(redisChannel, channel, message);
});

server.listen(3000, function () {
    console.log('Node server is running socket.js on port 3000');
});