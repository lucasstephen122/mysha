var rabbitmq = 
{
    socket : null,
    client : null,
    connect : function()
    {
        rabbitmq.socket = new SockJS('http://' + g['stomp']['host'] + ':' + g['stomp']['port'] + '/' + g['stomp']['context']);
        rabbitmq.client = Stomp.over(rabbitmq.socket);

        rabbitmq.client.heartbeat.outgoing = 0;
        rabbitmq.client.heartbeat.incoming = 0;
        rabbitmq.client.debug = function(m)
        {
            // console.log(m);
        };

        var on_connect = function(x) 
        {
            $(document).trigger('rabbitmq_ready');
        };

        var on_error =  function() 
        {
            console.log('rabbitmq error');
        };

        rabbitmq.client.connect(g['stomp']['user_name'], g['stomp']['password'], on_connect, on_error, '/');
    },

    send : function (queue , message)
    {
        rabbitmq.client.send('/exchange/' + queue, {"content-type":"text/plain"}, message);
    },

    listen : function (queue , callback)
    {
        id = rabbitmq.client.subscribe('/exchange/' + queue, function(d) 
        {
            callback(d.body);
        });
    }
}

$(document).ready(function() 
{
    rabbitmq.connect();
});