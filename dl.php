<?php

 #
 # MiniApps - framework
 #
 # info: main folder copyright file
 #
 #
 #

# userpage

# load config 
if (file_exists("config/config.php")){
	include("config/config.php");
}

echo($MA_DOCTYPE);
 
for ($i=0;$i<count($MA_LIB);$i++){
	if (file_exists("$MA_LIB[$i]")){
		include("$MA_LIB[$i]");
	}
}


$MA_USERPAGE=true;

# css setting
setcss();

# load local app file
if (file_exists("$MA_APPFILE")){
	include("$MA_APPFILE");
}
if (function_exists("userpage")){
	userpage();
}

# end local app file
if (file_exists("$MA_JS_END")){
	include("$MA_JS_END");
}


?>
