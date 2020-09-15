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
