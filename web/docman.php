<?php

 #
 # DocMan - document manager for website
 #
 # info: main folder copyright file
 #
 #

# configuration - need change it


include("config/config.php");
include("$DM_HEADER");
#include("$DM_CSS");


function dirlist($dir) {
	global $DM_CONFIG_DIR;

    $result=array();
    $cdir=scandir($dir);
    foreach ($cdir as $key => $value){
		if (!in_array($value,array(".","..",$DM_CONFIG_DIR))){
			$result[]=$value;
		}
	}
	return $result;
}





$d=dirlist($DM_DOC_ROOT);

$db=count($d);
for ($i=0;$i<$db;$i++){
	$dn=$DM_DOC_ROOT."/".$d[$i];
	if (is_dir($dn)){
		$d2=dirlist($dn);
		if (count($d2)>0){
			echo("<section id=s1>");
			echo("<h2>$d[$i]</h2>");
			echo("<section id=s2>");
			$db2=count($d2);
			for ($k=0;$k<$db2;$k++){
				$fn=$DM_DOC_ROOT."/".$d[$i]."/".$d2[$k];
				echo("<a href=$fn>$d2[$k]</a><br />");
			}
			echo("</section>");
			echo("</section>");
		}
	}
}





include("$DM_FOOTER");

?>
