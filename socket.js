var httpServer = require('http').Server();
//var io = require('socket.io')(httpServer);
var Redis = require('ioredis');

var redis = new Redis({
    password: ''
});

redis.psubscribe('*', function (err, count) {
    console.log(err);
});

var io = require('socket.io')(httpServer);


var Helper = {
    getChats: function (message) {
        io.emit('chats-' + message.user.id, message.chats);
    }, getMessage: function (message) {
        io.emit('messages-' + message.reciver_id, message.msgs)
    }, getNotifications: function (message) {
        console.log(message.notification[0].notifier);
        io.emit('notifications-' + message.notifier, message.notification[0]);
    },getNotificationsCount: function (message) {
        io.emit('notifications-count-'+message.user.id,message.count);
    }
};

// listen to socket connections
io.sockets.on("connection", function (socket) {
    socket.on('subscribe', function (data) {

    });

    socket.on("disconnect", function (disSocket) {

    });

});

redis.on('pmessage', function (subscribed, channel, message) {
    message = JSON.parse(message);
    if (message.event == 'chats.get') {
        Helper.getChats(message.data);
    } else if (message.event == 'message.get') {

    } else if (message.event == 'notifications.get') {
        Helper.getNotifications(message.data);
    }else if(message.event == 'notifications.count.get'){
        Helper.getNotificationsCount(message.data);
    }
});
// httpsServer.listen(443);
httpServer.listen(3000);