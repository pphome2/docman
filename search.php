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

for ($i=0;$i<count($MA_LIB);$i++){
	if (file_exists("$MA_LIB[$i]")){
		include("$MA_LIB[$i]");
	}
}

# cookies or param 
setcss();

# page build
page_header();



# privacy data to screen

$MA_NOPAGE=true;

if (file_exists("$MA_APPFILE")){
	include("$MA_APPFILE");
}

if (function_exists("searchpage")){
	searchpage();
}

button_back();

# end



# page end
page_footer();
	

?>
