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


<div style="width: 30%;" class="b">
    <div style="width: 350px;height: 500px;border: 1px solid black;overflow-y: auto;"  id="list"></div>
    <input type="text" id="message">
    <input type="button" value="发送" id="btn">
    <div id="bqlist" style="width: 50%;height: auto;"></div>
    <p style="display: none" id="aa">{{$data}}</p>
</div>
<div style="width: 10%" class="c">
    <div class="onlinelist" style="border: 1px solid black;height: 50%;">粉丝在线列表</div></div>
<div style="clear: both;margin-left: 5%;">
    @foreach($res as $k=>$v)
        <span style="display:none;">{{$v['id']}}</span>
        <img src="{{$v['img']}}" alt="" style="float:left;width:40px;height:40px;padding:30px;" class="liwu">
    @endforeach
</div>
</body>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    var player = new Aliplayer({
    "id": "player-con",
    "source": "rtmp://youke.1548580932.top/myfirstvideo/video?auth_key=1583336657-0-0-336764153eb4d94d74929381c7d0bbed",
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
    var username=$("#aa").text();
    console.log(username)
    var ws=new WebSocket("ws://116.62.15.33:9502");

    ws.onopen= function () {
        var message='{"type":"login","con":"'+username+'"}';
        // console.log(message)
        ws.send(message);
    }
    ws.onmessage = function (res) {
        var data=JSON.parse(res.data);
        // console.log(data)
        if(data.is_me==1 && data.type=='login'){
            var content="<p style='text-align: center'>尊敬的用户："+data.username+"欢迎您的到来</p>";
        }else if(data.is_me==0 && data.type=='login'){
            var content="<p style='text-align: center'>系统消息："+data.username+"上线了</p>";
        }else if( data.type=='message'){
            var content="<div align='left'><p style='margin-left: 20px'>"+data.username+"："+data.message+"</p>";
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
$(document).on("click",".liwu",function () {
    var lid=$(this).prev("span").text();
    // var username=$(this).parent('div').siblings('div').children('#aa').text();
    console.log(username)
    $.ajax({
        url:"{{URL("/checkliwu")}}",
        method:"post",
        data:{id:lid,username:username}
    }).done(function (res) {
        console.log(res)
    })
})

    $(document).on("click",".liwu",function () {
        var src=$(this).attr("src");
        var con="<img src='"+src+"'>";
        var message='{"type":"message","con":"'+con+'"}';
        ws.send(message);
    })
</script>
</html>