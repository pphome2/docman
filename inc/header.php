<?php

 #
 # MiniApps - framework
 #
 # info: main folder copyright file
 #
 #

?>

<html>
	<head>
		<title><?php echo($MA_SITENAME." - ".$L_SITENAME); ?></title>
		<meta charset="utf-8" />
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="icon" href="favicon.png">
		<link rel="shortcut icon" type="image/png" href="favicon.png" />
		<style><?php include("$MA_CSS[$MA_STYLEINDEX]"); ?></style>
	</head>
<body>


<div class=all-page>


<header>
<div class="menu">
<ul class="sidenav">


<?php

	echo("<li><a class=\"active\" href=\"$MA_SITE_HOME\">$L_SITEHOME</a></li>");

	if ($MA_ENABLE_COOKIES){
		echo("<li><a href=\"$MA_ADMINFILE\">$L_MTHOME</a></li>");
	}else{
		echo("<li><a href=\"$MA_ADMINFILE.'?'.$MA_COOKIE_STYLE.'='.$MA_STYLEINDEX);\">$L_MTHOME</a></li>");
	}

	if ($MA_LOGGEDIN){
		if (count($MA_MENU)>0){
			$db=count($MA_MENU);
			for ($i=0;$i<$db;$i++){
				echo("<li><a href=\"?$MA_MENU_FIELD=".$MA_MENU[$i][1]."\">".$MA_MENU[$i][0]."</a></li>");
			}
		}
		if ($MA_ADMIN_USER){
			if (count($MA_ADMINMENU)>0){
				$db=count($MA_ADMINMENU);
				for ($i=0;$i<$db;$i++){
					echo("<li><a href=\"?$MA_ADMINMENU_FIELD=".$MA_ADMINMENU[$i][1]."\">".$MA_ADMINMENU[$i][0]."</a></li>");
				}
			}
		}
?>

		<li class="liright">
			<a href="<?php echo($MA_SEARCH_ICON_HREF); ?>" onclick="<?php echo($MA_SEARCH_ICON_JS); ?>">
			<div class="search_icon">&#9740;</div>
			</a>
		</li>
	
<?php
		if ($MA_LOGOUT_IN_HEADER){
			echo("<li class=\"liright\">");
			echo("<a href=#
				onclick=\"document.cookie='$MA_COOKIE_PASSWORD=$L_LOGOUT; expires=Thu, 01 Jan 1970 00:00:00 UTC;';window.location = window.location.href;\">$L_LOGOUT</a>");
			echo("</li>");
		}
	}
?>
</ul>
</div>

</header>

<div class="content">

