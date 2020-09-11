<?php

 #
 # MiniApps - framework
 #
 # info: main folder copyright file
 #
 #


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

if (file_exists("$MA_CONFIG_DIR/$MA_LANGFILE")){
	include("$MA_CONFIG_DIR/$MA_LANGFILE");
}

# css setting
setcss();

# login
login();

# build page: header
page_header();

if ($MA_LOGGEDIN){

	# private menu
	if (isset($_GET["$MA_MENU_FIELD"])){
		$MA_APPFILE=$MA_CONTENT_DIR."/".$_GET["$MA_MENU_FIELD"];
	}
	# load local app file
	if (file_exists("$MA_APPFILE")){
		include("$MA_APPFILE");
	}
	if (function_exists("main")){
		main();
	}
	
}else{
	login_form();
}

# end local app file


# page end
page_footer();

?>
