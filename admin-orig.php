<?php

 #
 # DocMan - document manager for website
 #
 # info: main folder copyright file
 #
 #

# configuration - need change it

setlocale(LC_ALL, 'hu_HU.UTF8');

# prepare
include("config/config.php");
include("config/$DM_LANGFILE");
include("$DM_HEADER");



# functions

function dirnametostore($n) {
	$n=str_replace(' ','_',$n);
	$n=str_replace('\'','(',$n);
	return($n);
}


function dirlist($dir) {
	global $DM_CONFIG_DIR;

    $result=array();
    $cdir=scandir($dir);
    foreach ($cdir as $key => $value){
		if (!in_array($value,array(".","..",$DM_CONFIG_DIR))){
			$result[]=$value;
		}
	}
	return($result);
}

function toascii($str) {
	#$clean=preg_replace("/[^A-Za-z0-9\_\-\.]/",'',$str);
	$clean=preg_replace("/[&'\ \"]/","_",$str);
	#echo($clean."?");
	return($clean);
}

function fileup($target_dir){
	global $_POST,$_FILES;
	$ret=FALSE;
	$target_file=basename($_FILES["fileupload"]["name"]);
	if ($target_file<>""){
		$target_file=toascii($target_file);
		if ($target_dir<>""){
			$target_file=$target_dir."/".$target_file;
		}
		$c=$_FILES["fileupload"]["tmp_name"];
		if (move_uploaded_file($_FILES["fileupload"]["tmp_name"],$target_file)) {
			$ret=TRUE;
		}
	}
	return($ret);
}


function mess_error($m){
	echo('
	<div class="message">
  		<div onclick="this.parentElement.style.display=\'none\'" class="toprightclose"></div>
  		<p style="padding-left:40px;">'.$m.'</p>
	</div>
	');
}


function mess_ok($m){
	echo('
		<div class="card">
  			<div onclick="this.parentElement.style.display=\'none\'" class="toprightclose"></div>
  			<div class=card-header>
  				<span onclick="var x=document.getElementById(\'cardbody\');if (x.style.display==\'none\'){x.style.display=\'block\'}else{x.style.display=\'none\'}"
  				class="topleftmenu1"></span></div>
  			<div class="cardbody" id="cardbody">
  				<p style="padding-left:40px;padding-bottom:20px;">'.$m.'</p>
  			</div>
		</div>
	');
}




# main


echo("<section id=message>");

# if submit button

if (isset($_POST["submitall"])){
	if (isset($_POST["userpass"])){
		$p=$_POST["userpass"];
		if (md5($p)==$DM_PASS){
			#$p1=$_POST["userpass"];

			# file upload

			if (isset($_FILES["fileupload"])) {
				if (basename($_FILES["fileupload"]["name"])<>""){
					$dir=$DM_DOC_ROOT."/".$_POST["sect"];
					$ok=fileup($dir);
					if ($ok){
						mess_ok($L_FILEUP." - ".$L_OK.".");
					}else{
						mess_error($L_FILEUP." - ".$dir." - ".$L_ERROR.".");
					}
				}
			}

			# delete file(s)

			if (isset($_POST["file"])) {
				$fn=$_POST["file"];
				foreach ($fn as $fname){
					if ($fname<>""){
						$fd=$fname;
						#echo($fd."<br />");
						if (unlink($fd)){
							mess_ok($L_FILEDELETE." - ".$L_OK.".");
						}else{
							mess_error($L_FILEDELETE." - ".$fd." - ".$L_ERROR.".");
						}
					}
				}
			}

			# create section

			if (isset($_POST["seccre"])) {
				$fn=$_POST["seccre"];
				if ($fn<>""){
					$fn=dirnametostore($fn);
					if (mkdir($fn)){
						mess_ok($L_SECTIONCREATE." - ".$L_OK.".");
					}else{
						mess_error($L_SECTIONCREATE." - ".$fn." - ".$L_ERROR.".");
					}
				}
			}

			# delete section

			if (isset($_POST["secdel"])) {
				$fn=$_POST["secdel"];
				if ($fn<>""){
					$fn=$DM_DOC_ROOT."/".$fn;
					if (rmdir($fn)){
						mess_ok($L_SECTIONDELETE." - ".$L_OK.".");
					}else{
						mess_error($L_SECTIONDELETE." - ".$fn." - ".$L_ERROR.".");
					}
				}
			}

			#echo("$p1 - $p2");
		}else{
			mess_error($L_NOACCESS.".");
		}
	}
}else{
	if (isset($_POST["submitall"])){
		mess_error($L_NODATA.".");
	}
}
echo("</section>");




$d=dirlist($DM_DOC_ROOT);

# form: passcode
echo("<section id=f1>");
echo("<h2>$L_ADMINISTRATION</h2>");

# form tabs

echo('
	<div class="containerbox">
	<div class="card-header-tab">
  		<button id="card1button" class="card-button tablinks active" onclick="opentab(event, \'tfup\')" id=defaultOpen>'.$L_FILESELECT.'</button>
  		<button class="card-button tablinks" onclick="opentab(event, \'tsecnew\')">'.$L_SECTIONCREATE.'</button>
	  	<button class="card-button tablinks" onclick="opentab(event, \'tsecdel\')">'.$L_SECTIONDELETE.'</button>
	  	<button class="card-button tablinks" onclick="opentab(event, \'tdocdel\')">'.$L_DOCDELETE.'</button>
	</div>
');



# form: upload
echo("<div id=\"tfup\" class=\"card-body\" style='display:nnone;'>");
	echo("<h2>$L_FILEUP</h2>");
	echo("<section id=form1>");
	echo("<form id=1 method=post enctype=multipart/form-data>");
	echo("<label for=userpass>$L_FILEPASS : </label>");
	echo("<input name=userpass id=userpass type=password>");
	echo("<select name=sect id=sect style='padding-top:20px;'>");
	$db=count($d);
	for ($i=0;$i<$db;$i++){
		$dn=$DM_DOC_ROOT."/".$d[$i];
		if (is_dir($dn)>0){
			echo("<option>$d[$i]");
		}
	}
	echo("</select>");
	echo("<input type=file name=fileupload id=fileupload class=inputfile style='padding-top:20px;'>");
	echo("<label for=fileupload>$L_FILESELECT</label>");
	echo("<input type=submit id=submitall name=submitall class=card-button value=$L_BUTTON_ALL>");
	echo("</form>");
	echo("</section>");
echo("</div>");

# form: folder create
echo("<div id=\"tsecnew\" class=\"card-body\"  style='display:none;'>");
	echo("<h2>$L_SECTIONCREATE</h2>");
	echo("<section id=form1>");
	echo("<form id=2 method=post enctype=multipart/form-data>");
	echo("<label for=userpass>$L_FILEPASS : </label>");
	echo("<input name=userpass id=userpass type=password>");
	echo("<label for=userpass>$L_CREATE : </label>");
	echo("<input name=seccre id=seccre type=text>");
	echo("<input type=submit id=submitall name=submitall class=card-button value=$L_BUTTON_ALL>");
	echo("</form>");
	echo("</section>");
echo("</div>");

# form: folder delete
echo("<div id=\"tsecdel\" class=\"card-body\" style='display:none;'>");
	echo("<h2>$L_SECTIONDELETE</h2>");
	echo("<section id=form1>");
	echo("<form id=3 method=post enctype=multipart/form-data>");
	echo("<label for=userpass>$L_FILEPASS : </label>");
	echo("<input name=userpass id=userpass type=password>");
	echo("<select name=secdel id=secdel>");
	echo("<option>");
	$db=count($d);
	for ($i=0;$i<$db;$i++){
		$dn=$DM_DOC_ROOT."/".$d[$i];
		if (is_dir($dn)>0){
			echo("<option>$d[$i]");
		}
	}

	echo("</select>");
	echo("<input type=submit id=submitall name=submitall class=card-button value=$L_BUTTON_ALL>");
	echo("</form>");
	echo("</section>");
echo("</div>");

# form: file delete
echo("<div id=\"tdocdel\" class=\"card-body\" style='display:none;'>");
	echo("<h2>$L_DELETE</h2>");
	echo("<section id=form1>");
	echo("<form id=4 method=post enctype=multipart/form-data>");
	echo("<label for=userpass>$L_FILEPASS : </label>");
	echo("<input name=userpass id=userpass type=password>");
	$db=count($d);
	for ($i=0;$i<$db;$i++){
		$dn=$DM_DOC_ROOT."/".$d[$i];
		if (is_dir($dn)){
			$d2=dirlist($dn);
			if (count($d2)>0){
				#echo("<section id=s1>");
				echo("<h2>$d[$i]</h2>");
				echo("<div class=panel>");
					echo("<section id=s2>");
					echo("<section id=formx style='padding-left:40px;'>");
					$db2=count($d2);
					for ($k=0;$k<$db2;$k++){
						$fn=$DM_DOC_ROOT."/".$d[$i]."/".$d2[$k];
						echo('<p>');
						echo("<input type=checkbox name=file[] id=file value=\"$fn\"><a style='text-decoration:none;' href=$fn>$d2[$k]</a>");						
						echo('</p>');
					}
					echo("</section>");
					echo("</section>");
				echo("</div>");
				#echo("</section>");
			}
		}
	}
	echo("<input type=submit id=submitall name=submitall class=card-button value=$L_BUTTON_ALL>");
	echo("</form>");
	echo("</section>");
echo("</div>");

echo("</section>");

include("$DM_JS_END");

include("$DM_FOOTER");

?>
