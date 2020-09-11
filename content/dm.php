<?php

 #
 # DocMan - simple documentmanagment for websites
 #
 # info: main folder copyright file
 #
 #


function userpage(){
	global $MA_CONTENT_DIR;
	
	if (file_exists("$MA_CONTENT_DIR/user.php")){
		include("$MA_CONTENT_DIR/user.php");
	}
	if (function_exists("up")){
		up();
	}
}

function searchpage(){
	echo("search page");
}


function privacypage(){
	global $L_PRIVACY_HEADER,$L_PRIVACY_TEXT, $L_BACKPAGE, $MA_NOPAGE;

	echo("<div class=\"content\">");
	echo("<h1>".$L_PRIVACY_HEADER."</h1>");
	echo("<div class=\"spaceline\"></div>");
	echo("<p>".$L_PRIVACY_TEXT."</p>");
	echo("</div>");
}


function printpage(){
	echo("print page");
}


function dirnametostore($n) {
	$n=str_replace(' ','_',$n);
	$n=str_replace('\'','(',$n);
	return($n);
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



function main(){
	global $DM_DOC_ROOT,$L_FILE_UP,$L_ERROR,$L_OK,$L_FILEDELETE,$L_SECTIONCREATE,$L_SECTIONDELETE,
			$L_DOCDELETE,$L_FILESELECT,$L_CREATE,$L_BUTTON_ALL,$L_FILEUP,$L_SECTION;

	echo("<section id=message>");

	# if submit button

	if (isset($_POST["submitall"])){
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
		if (isset($_POST["delfile"])) {
			$fn=$_POST["delfile"];
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
			$fn=vinput($_POST["seccre"]);
			if ($fn<>""){
				$fn=$DM_DOC_ROOT."/".$fn;
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
			$fn=vinput($_POST["secdel"]);
			if ($fn<>""){
				$fn=$DM_DOC_ROOT."/".$fn;
				if (is_dir($fn)) {
					$objects = scandir($fn);
					foreach ($objects as $object) {
						if ($object != "." && $object != "..") {
							unlink($fn."/".$object);
						}
					}
				}
				if (rmdir($fn)){
					mess_ok($L_SECTIONDELETE." - ".$L_OK.".");
				}else{
					mess_error($L_SECTIONDELETE." - ".$fn." - ".$L_ERROR.".");
				}
			}
		}
		#echo("$p1 - $p2");
	}
	echo("</section>");
	
	$d=dirlist($DM_DOC_ROOT);

	# form tabs
	echo('
		<div class="containerbox">
		<div class="card-header-tab">
			<button id="card1button" class="card-button tablinks activetab" onclick="opentab(event, \'tfup\')" id=defaultOpen>'.$L_FILESELECT.'</button>
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
		echo("<select name=sect id=sect style='padding-top:20px;'>");
		$db=count($d);
		for ($i=0;$i<$db;$i++){
			$dn=$DM_DOC_ROOT."/".$d[$i];
			if (is_dir($dn)>0){
				echo("<option>$d[$i]");
			}
		}
		echo("</select>");
		echo("<div class=spaceline></div>");
		#echo("<input type=file name=fileupload id=fileupload class=inputfile>");
		#echo("<label for=fileupload><div class=inputbutton>$L_FILESELECT</div></label>");
		#echo("<div class=spaceline></div>");
		echo("<div class='upload-btn-wrapper'>");
		echo("<input type='file' name=fileupload id=fileupload  />");
		echo("<label for=fileupload class='upload-btn'>$L_FILESELECT</label>");
		echo("</div>");
		echo("<div class=spaceline></div>");
		echo("<input type=submit id=submitall name=submitall class=card-button value=$L_BUTTON_ALL>");
		echo("</form>");
		echo("</section>");
	echo("</div>");
	
	# form: folder create
	echo("<div id=\"tsecnew\" class=\"card-body\"  style='display:none;'>");
		echo("<h2>$L_SECTIONCREATE</h2>");
		echo("<section id=form1>");
		echo("<form id=2 method=post enctype=multipart/form-data>");
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
		$db=count($d);
		for ($i=0;$i<$db;$i++){
			$dn=$DM_DOC_ROOT."/".$d[$i];
			if (is_dir($dn)){
				$d2=dirlist($dn);
				if (count($d2)>0){
					#echo("<section id=s1>");
					echo("<h2>$L_SECTION: $d[$i]</h2>");
					echo("<div class=panel>");
					echo("<section id=s2>");
					echo("<section id=formx style='padding-left:40px;'>");
					$db2=count($d2);
					for ($k=0;$k<$db2;$k++){
						$fn=$DM_DOC_ROOT."/".$d[$i]."/".$d2[$k];
						echo($fn);
						echo('<p>');
						echo("<input type=checkbox name=delfile[] id=delfile value=\"$fn\"><a style='text-decoration:none;' href=$fn>$d2[$k]</a>");						
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

	echo("</div>");


	
}


?>
