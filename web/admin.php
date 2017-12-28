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
include("$DM_HEADER");


# functions

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



# main

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
						echo($L_OK.".");
					}else{
						echo($L_FILEUP." - ".$dir." - ".$L_ERROR.".");
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
							echo($L_OK.".");
						}else{
							echo($L_FILEDELETE." - ".$fd." - ".$L_ERROR.".");
						}
					}
				}
			}

			# create section

			if (isset($_POST["seccre"])) {
				$fn=$_POST["seccre"];
				if ($fn<>""){
					#$fn=$DM_DOC_ROOT."/".$fn;
					if (mkdir($fn)){
						echo($L_OK.".");
					}else{
						echo($L_SECTIONCREATE." - ".$fn." - ".$L_ERROR.".");
					}
				}
			}

			# delete section

			if (isset($_POST["secdel"])) {
				$fn=$_POST["secdel"];
				if ($fn<>""){
					$fn=$DM_DOC_ROOT."/".$fn;
					if (rmdir($fn)){
						echo($L_OK.".");
					}else{
						echo($L_SECTIONDELETE." - ".$fn." - ".$L_ERROR.".");
					}
				}
			}

			#echo("$p1 - $p2");
		}else{
			echo($L_NOACCESS.".");
		}
		echo("<br /><br />");
	}
}else{
	if (isset($_POST["submitall"])){
		echo($L_NODATA.".");
		echo("<br /><br />");
	}
}




$d=dirlist($DM_DOC_ROOT);

# form: upload
echo("<section id=f1>");
echo("<h2>$L_ADMINISTRATION</h2>");
echo("<form method=post enctype=multipart/form-data>");
echo("<label for=userpass>$L_FILEPASS : </label>");
echo("<input name=userpass id=userpass type=password><br /><br />");

echo("<h2>$L_FILEUP</h2>");
echo("<section id=form1>");
	echo("<label for=sect>$L_FILESELECTION : </label>");
	echo("<select name=sect id=sect>");

	$db=count($d);
	for ($i=0;$i<$db;$i++){
		$dn=$DM_DOC_ROOT."/".$d[$i];
		if (is_dir($dn)>0){
			echo("<option>$d[$i]");
		}
	}

	echo("</select>");
	#echo("<br /><br />");
	echo(" <input type=file name=fileupload id=fileupload class=inputfile>");
	echo("<label for=fileupload>$L_FILESELECT</label><br /><br />");
echo("</section>");


# form: folder delete
echo("<h2>$L_SECTIONDELETE</h2>");
echo("<section id=form1>");
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
	echo("<br /><br />");
echo("</section>");

# form: folder create
echo("<h2>$L_SECTIONCREATE</h2>");
echo("<section id=form1>");
	echo("<label for=userpass>$L_CREATE : </label>");
	echo("<input name=seccre id=seccre type=text><br /><br />");
	echo("<br /><br />");
echo("</section>");

# form: file delete
$db=count($d);
for ($i=0;$i<$db;$i++){
	$dn=$DM_DOC_ROOT."/".$d[$i];
	if (is_dir($dn)){
		$d2=dirlist($dn);
		if (count($d2)>0){
			echo("<section id=s1>");
			echo("<h1>$d[$i]<br /></h1>");
			echo("<section id=s2>");
			echo("<section id=formx>");
			$db2=count($d2);
			for ($k=0;$k<$db2;$k++){
				$fn=$DM_DOC_ROOT."/".$d[$i]."/".$d2[$k];
				echo("<input type=checkbox name=file[] id=file value=\"$fn\"><a href=$fn>$d2[$k]</a><br />");
			}
			echo("</section>");
			echo("</section>");
			echo("</section>");
		}
	}
}

echo("<br /><button type=submit id=submitall name=submitall class=button>$L_BUTTON_ALL</button><br /><br />");
echo("</form>");
echo("</section>");

include("$DM_FOOTER");

?>
