<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title>请在浏览器打开</title>
</head>
<body>
        <style type="text/css">
        *{margin:0; padding:0;}
        img{max-width: 100%; height: auto;}
        .tips-div{height: 600px; max-width: 600px; font-size: 40px;}
        </style>
        <div class="tips-div">

        </div>
        <input type="hidden" class="url" value="<?php echo $url;?>">
</button>

        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdn.bootcss.com/clipboard.js/2.0.4/clipboard.js"></script>
        <script src="/js/layer_mobile/layer.js"></script>
        <script type="text/javascript">
                var url = $(".url").val();
                var winHeight = typeof window.innerHeight != 'undefined' ? window.innerHeight : document.documentElement.clientHeight;
                function loadHtml(){
                        var div = document.createElement('div');
                        div.id = 'weixin-tip';
                        div.innerHTML = '<p><img src="./live_weixin.png" alt="微信打开"  data-clipboard-text="'+url+'"/></p>';
                        document.body.appendChild(div);
                }
                
                function loadStyleText(cssText) {
                var style = document.createElement('style');
                style.rel = 'stylesheet';
                style.type = 'text/css';
                try {
                    style.appendChild(document.createTextNode(cssText));
                } catch (e) {
                    style.styleSheet.cssText = cssText; //ie9以下
                }
            var head=document.getElementsByTagName("head")[0]; //head标签之间加上style样式
            head.appendChild(style); 
            }
            var cssText = "#weixin-tip{position: fixed; left:0; top:0; background: rgba(0,0,0,0.8); filter:alpha(opacity=80); width: 100%; height:100%; z-index: 100;} #weixin-tip p{text-align: center; margin-top: 10%; padding:0 5%;}";
               
        loadHtml();
        loadStyleText(cssText);
            
        var clipboard = new ClipboardJS('img');
        clipboard.on('success', function(e) {
             //底部对话框
            layer.open({
                content: url
                ,btn: ['关闭', '已经复制成功，右上角打开浏览器']
                ,skin: 'footer'
            });
        });
        clipboard.on('error', function(e) {
             //底部对话框
            layer.open({
                content: url
                ,btn: ['复制失败请长按复制以上网站', '复制失败']
                ,skin: 'footer'
            });
        });
           
        </script>
</body>
</html>