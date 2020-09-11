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
if (file_exists("$MA_LIB")){
	include("$MA_LIB");
}
if (file_exists("$MA_CONFIG_DIR/$MA_LANGFILE")){
	include("$MA_CONFIG_DIR/$MA_LANGFILE");
}


# build page
echo("<html>");
echo("<head>");
echo("<title>$MA_SITENAME</title><style>");
include("$MA_CSSPRINT");
echo("</style>");
echo("<head>");
echo("<body onclick=\"window.close();\">");


# load local app file

$MA_NOPAGE=true;

if (file_exists("$MA_APPFILE")){
	include("$MA_APPFILE");
}

if (function_exists("printpage")){
	printpage();
}

# end

echo("<script>window.print();</script>");

echo("</body>");
echo("</html>");

?>
