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
include("$DM_CSS2");
include("$DM_JS_BEGIN");


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


function dirnametofine($n) {
	$n=str_replace('_',' ',$n);
	return($n);
}







$d=dirlist($DM_DOC_ROOT);

$db=count($d);
for ($i=0;$i<$db;$i++){
	$dn=$DM_DOC_ROOT."/".$d[$i];
	if (is_dir($dn)){
		$d2=dirlist($dn);
		if (count($d2)>0){
			echo('
				<div class="card">
  					<div onclick="this.parentElement.style.display=\'none\'" class="toprightclose"></div>
  					<div class=card-header>
  						<span onclick="cardclose(cardbody'.$i.')" class="topleftmenu1"></span>');
  			echo(dirnametofine($d[$i]));
  			echo('
  					</div>
  					<div class="cardbody" id="cardbody'.$i.'" style="display:none;"><div style="padding:10px;">
  			');
			$db2=count($d2);
			for ($k=0;$k<$db2;$k++){
				$fn=$DM_DOC_ROOT."/".$d[$i]."/".$d2[$k];
				echo("<p><a href=$fn>$d2[$k]</a></p>");
			}
			echo('
  					</div>
  					<div class=card-footer><span class=button_ok onclick="cardclose(cardbody'.$i.')"></span></div>
  				</div></div>
			');
			
		}
	}
}





include("$DM_JS_END");
include("$DM_FOOTER");

?>
