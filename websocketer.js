
<button id="bt-click">click</button>
<script>
    ws = new WebSocket("ws://xxxxxx:2345");
    ws.onopen = function() {
        ws.send('tom');
    };
    ws.onmessage = function(e) {
        console.log("收到服务端的消息：" + e.data);
    };
    $('#bt-click').click(function(){
                ws.send('lakers');
            }

    )



</script>

