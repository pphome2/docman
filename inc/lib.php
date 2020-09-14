
<?php

 #
 # MiniApps - framework
 #
 # info: main folder copyright file
 #
 #



# login from cookie or param
function login(){
	global $MA_LOGGEDIN,$MA_LOGIN_TIME,$MA_PASSWORD,$MA_ENABLE_COOKIES,$MA_COOKIE_PASSWORD,
			$MA_USER_PASS,$MA_ADMIN_PASS,$MA_ADMIN_USER,$MA_LOGIN_TIME,$MA_LOGIN_TIMEOUT,
			$MA_COOKIE_TIME;
	
	$MA_LOGGEDIN=false;
	$MA_LOGIN_TIME=time();
	$MA_PASSWORD="";

	if ($MA_ENABLE_COOKIES){
		$MA_PASSWORD=$_COOKIE[$MA_COOKIE_PASSWORD];
		if (($MA_PASSWORD==$MA_USER_PASS)or($MA_PASSWORD==$MA_ADMIN_PASS)){
			$MA_LOGGEDIN=true;
		}
		if ($MA_PASSWORD==$MA_ADMIN_PASS){
			$MA_ADMIN_USER=true;
		}
	}
	if ($MA_PASSWORD==""){
		if (isset($_POST["$MA_COOKIE_PASSWORD"])){
			$MA_PASSWORD=$_POST["$MA_COOKIE_PASSWORD"];
			$MA_PASSWORD=vinput($MA_PASSWORD);
			if ((md5($MA_PASSWORD)==$MA_USER_PASS)or(md5($MA_PASSWORD)==$MA_ADMIN_PASS)){
				$MA_PASSWORD=md5($MA_PASSWORD);
			}
			if (($MA_PASSWORD==$MA_USER_PASS)or($MA_PASSWORD==$MA_ADMIN_PASS)){
				if (isset($_POST["$MA_COOKIE_TIME"])){
					$outime=$_POST["$MA_COOKIE_TIME"];
					$outime=vinput($outime);
					$utime2=$MA_LOGIN_TIME-$outime;
					if ($utime2<$MA_LOGIN_TIMEOUT){
						$MA_LOGGEDIN=true;
					}
				}else{
					$MA_LOGGEDIN=true;
				}
				if ($MA_PASSWORD==$MA_ADMIN_PASS){
					$MA_ADMIN_USER=true;
				}
			}
		}
	}
	if (($MA_ENABLE_COOKIES)and($MA_LOGGEDIN)){
		setcookie($MA_COOKIE_PASSWORD, $MA_PASSWORD, time()+$MA_LOGIN_TIMEOUT); 
	}
	if (!$MA_LOGGEDIN){
		setcookie($MA_COOKIE_PASSWORD, "", time() - 3600);
	}
}


# cookies or param
function setcss(){
	global $MA_ENABLE_COOKIES,$MA_STYLEINDEX,$MA_COOKIE_STYLE,$MA_CSS;
	
	if ($MA_ENABLE_COOKIES){
		$MA_STYLEINDEX=intval(vinput($_COOKIE[$MA_COOKIE_STYLE]));
	}else{
		if (isset($_POST[$MA_COOKIE_STYLE])){
			$MA_STYLEINDEX=htmlspecialchars($_POST[$MA_COOKIE_STYLE]);
		}else{
			if (isset($_GET[$MA_COOKIE_STYLE])){
				$MA_STYLEINDEX=htmlspecialchars($_GET[$MA_COOKIE_STYLE]);
			}else{
			$MA_STYLEINDEX=0;
			}
		}
	}
	if ($MA_STYLEINDEX>count($MA_CSS)){
		$MA_STYLEINDEX=0;
	}
}



# page header
function page_header(){
	global $MA_HEADER,$MA_JS_BEGIN,$MA_CSS,$MA_STYLEINDEX,$MA_SITENAME,$MA_SITE_HOME,$MA_CSS,
			$L_SITEHOME,$MA_ENABLE_COOKIES,$MA_ADMINFILE,$L_MTHOME,$MA_COOKIE_STYLE,
			$MA_MENU,$MA_MENU_FIELD,$MA_LOGGEDIN,$MA_COOKIE_PASSWORD,$L_LOGOUT,
			$MA_SEARCH_ICON_HREF,$MA_SEARCH_ICON_JS,$MA_LOGOUT_IN_HEADER,$L_SITENAME;
	
	if (file_exists("$MA_HEADER")){
		include("$MA_HEADER");
	}
	if (file_exists("$MA_JS_BEGIN")){
		include("$MT_JS_BEGIN");
	}
}


# page footer
function page_footer(){
	global $MA_JS_END,$MA_FOOTER,$MA_ADMINFILE,$MA_LOGIN_TIMEOUT,$MA_COOKIE_STYLE,$MA_STYLEINDEX,
			$MA_COPYRIGHT,$MA_CSS,$MA_ENABLE_COOKIES,$MA_COOKIE_STYLE,$L_THEME,$MA_PRIVACY,
			$L_PRIVACY_MENU,$MA_LOGGEDIN,$MA_COOKIE_PASSWORD,$L_LOGOUT,$L_COOKIE_TEXT,$MA_PRIVACY_PAGE;
	
	if (file_exists("$MA_JS_END")){
		include("$MA_JS_END");
	}
	if (file_exists("$MA_FOOTER")){
		include("$MA_FOOTER");
	}
}

# functions
function vinput($d) {
    $d=trim($d);
    $d=stripslashes($d);
    $d=strip_tags($d);
    $d=htmlspecialchars($d);
    return $d;
}


function dirlist($dir) {
	global $MA_CONFIG_DIR;

    $result=array();
    $cdir=scandir($dir);
    foreach ($cdir as $key => $value){
		if (!in_array($value,array(".","..",$MA_CONFIG_DIR))){
			$result[]=$value;
		}
	}
	return $result;
}



?>
