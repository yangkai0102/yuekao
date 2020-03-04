<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge" >
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>
    <title>Aliplayer Online Settings</title>
    <link rel="stylesheet" href="https://g.alicdn.com/de/prismplayer/2.8.7/skins/default/aliplayer-min.css" />
    <script type="text/javascript" charset="utf-8" src="https://g.alicdn.com/de/prismplayer/2.8.7/aliplayer-min.js"></script>

    <title>Title</title>
    <style>
        .a,.b,.c{
            float: left;

        }
    </style>
</head>
<body>
<div class="a prism-player" id="player-con" style="width: 60%;">

</div>
<div style="width: 30%;" class="b">粉丝贡献榜
    <div style="width: 350px;height: 420px;border: 1px solid black;overflow-y: auto;"  id="list"></div>
    <input type="text" id="message">
    <input type="button" value="发送" id="btn">
    <img src="./bq.png" alt="" style="width: 30px;height: 30px;margin-top: 20px;" id="bq">
    <div id="bqlist" style="width: 50%;height: auto;"></div>
    <span style="display: none">{{$data}}</span>
</div>
<div style="width: 10%" class="c">
    <div class="onlinelist" style="border: 1px solid black;height: 50%;">粉丝在线列表</div></div>
</body>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    var player = new Aliplayer({
            "id": "player-con",
            "source": "rtmp://youke.1548580932.top/myfirstvideo/video?auth_key=1583116460-0-0-1ec33bcb4f808e3fdfdf0219bde4a93f",
            "width": "100%",
            "height": "500px",
            "autoplay": true,
            "isLive": true,
            "rePlay": false,
            "playsinline": true,
            "preload": true,
            "controlBarVisibility": "hover",
            "useH5Prism": true
        }, function (player) {
            console.log("The player is created");
        }
    );
</script>

<script>

//用户登录以后   获取用户名
    var username=$("span").text();
    var ws=new WebSocket("ws://116.62.15.33:9502");

    ws.onopen= function () {
        var message='{"type":"login","con":"username"}';
        ws.send(message);
    }
    ws.onmessage = function (res) {
        var data=JSON.parse(res.data);
        // console.log(data)
        if(data.is_me==1 && data.type=='login'){
            var content="<p style='text-align: center'>尊敬的用户："+data.username+"欢迎您的到来</p>";
        }else if(data.is_me==0 && data.type=='login'){
            var content="<p style='text-align: center'>系统消息："+data.username+"上线了</p>";
        }else if(data.is_me==1 && data.type=='message'){
            var content="<div align='right'><p style='margin-left: 20px'>来自您的消息</p><p style='border: 1px solid #ff0000;margin-right: 20px;" +
                "width: 20%;height: auto;border-radius: inherit;background-color: #00ffff'>"+data.message+"</p></div>";
        }else if(data.is_me==0 && data.type=='message'){
            var content="<div align='left'><p style='margin-left: 20px'>来自"+data.username+"的消息</p><p style='border: 1px solid #ff0000;margin-left: 20px;" +
                "width: 20%;height: auto;border-radius: inherit;background-color: #00ffff'>"+data.message+"</p></div>";
        }else if(data.is_me==0 && data.type=='loginout'){
            var content="<div style='text-align: center'>系统消息: "+data.username+"离开了</div>";
        }
        var list="在线用户列表";
        for (var i in data.online_list){
            list +="<p>"+data.online_list[i].username+"</p>"
        }
        $(".onlinelist").html(list);
        $("#list").append(content);

    }
    $(document).on("click","#btn",function () {
        // console.log(11)
        var con=$("#message").val();
        var message='{"type":"message","con":"'+con+'"}';
        ws.send(message);
    })
    $(document).on('click','#bq',function () {
        $.ajax({
            url:'./bq.php',
            dataType:"json",
            success:function (res) {
                //
                var img='';
                for(var i in res){
                    img +="<img class='bqimg' src='./bq/"+res[i]+"' style='width: 50px;height: 50px;'>";
                    // console.log(res[i]);
                }
                $("#bqlist").html(img);
            }
        })
    })
    $(document).on("click",".bqimg",function () {
        var src=$(this).attr("src");
        var con="<img src='"+src+"'>";
        var message='{"type":"message","con":"'+con+'"}';
        ws.send(message);

    })
</script>
</html>