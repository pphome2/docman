<?php

 #
 # DocMan - simple documentmanagment for websites
 #
 # info: main folder copyright file
 #
 #




global $DM_DOC_ROOT,$L_DOWNLOAD_PAGE_HEAD,$DM_LINK_TARGET_NEW_WINDOW,
		$DM_USER_CSS,$DM_USER_ALWAYS_CSS,$MA_STYLEINDEX,$L_VIEW,
		$DM_HEAD_TEXT;

?>

<!DOCTYPE HTM>
<html>
    <head>
		<title><?php echo($L_DOWNLOAD_PAGE_HEAD); ?></title>
		<meta charset="utf-8" />
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="favicon.png">
		<link rel="icon" type="image/x-icon" href="favicon.png">

		<style type="text/css">


		<?php
			if (!empty($DM_USER_ALWAYS_CSS)){
				if (file_exists($DM_USER_ALWAYS_CSS)){
					include($DM_USER_ALWAYS_CSS);
				}else{
					$MA_STYLEINDEX=0;
				}
			}else{
				if (file_exists($DM_USER_CSS[$MA_STYLEINDEX])){
					include($DM_USER_CSS[$MA_STYLEINDEX]);
				}else{
					if (file_exists($DM_USER_CSS[0])){
						include($DM_USER_CSS[0]);
					}
				}
			}
		?>

		</style>

    </head>

	<body>
		<div class=df-content>

<?php
	echo("<div class=\"menu\">");
	echo("<ul class=\"sidenav\">");
	if (!empty($DM_HEAD_TEXT)){
		echo("<li class=floatleft>$DM_HEAD_TEXT</li>");
		echo("<li class=floatright>$L_DOWNLOAD_PAGE_HEAD</li>");
	}else{
		echo("<li>$L_DOWNLOAD_PAGE_HEAD</li>");
	}
	echo("</ul>");
	echo("</div>");


function formatBytes($size, $precision=2){
    if($size < 0) {
        $size=$size + PHP_INT_MAX + PHP_INT_MAX + 2;
    }
    $base=log($size, 1024);
    $suffixes=array('', 'K', 'M', 'G', 'T');
    return round(pow(1024,$base-floor($base)),$precision).' '.$suffixes[floor($base)];
}



function filetable($dir){
    global $DM_DOC_ROOT,$L_COL1,$L_COL2,$L_COL3,$DM_TEXTFILE_EXT,$DM_FILEEXT,$L_DOWNLOAD_TEXT,$L_VIEW,
			$DM_VIEW_FILE,$cardnum,$dirnum;

	$files=scandir($dir);
	asort($files);
	$fdb=0;
	foreach ($files as $entry) {
		if ($entry!="." && $entry!=".." && $entry!="lost+found") {
			$dirn=$dir.'/'.$entry;
			if (is_dir($dirn)){
				if ($dirnum==0){
					$cardnum++;
					echo('
						<div class="df-card">
							<div  onclick="cardclose2(dfcardbody'.$cardnum.',dfcardright'.$cardnum.')" class="df-card-header" id="dfardheader'.$cardnum.'">
								<span class="df-topleftmenu1">'.$entry.'</span>
								<span class="df-topright" id="dfcardright'.$cardnum.'">+</span>
							</div>
						<div class="df-card-body" id="dfcardbody'.$cardnum.'" style="display:none;">
						');
					echo("<table class='df_table_full'>");
					echo("<tr class='df_trh'>");
					echo("<th class='df_th1'>$L_COL1</th>");
					echo("<th class='df_th2'>$L_COL2</th>");
					echo("<th class='df_th2'>$L_COL3</th>");
					echo("</tr>");
				}
				$dirnum++;
				filetable($dirn);
				$dirnum--;
				if ($dirnum==0){
					echo("</table>");
					echo("</center>");
					echo("</div>");
					echo("</div>");
				}
			}else{
				$fileext=explode('.',$entry);
				$fileext_name=$fileext[count($fileext)-1];
				$fileext_name2='.'.$fileext_name;
				if ((in_array($fileext_name, $DM_FILEEXT))or(in_array($fileext_name2, $DM_FILEEXT))){
					echo("<tr class='df_tr'>");
					$fileext_name=strtoupper($fileext_name);
					echo("<td class='df_td'><span class='df_tds'>[$fileext_name]</span> ");
					if ($DM_VIEW_FILE){
						echo("<a href='$dir/$entry' target='$target' class='df_tda'>$entry</a>");
					}else{
						echo($entry);
					}
					echo("<a href='$dir/$entry' download class='df_tda2' onclick='delrow(this);'><button class='df_butt'>$L_DOWNLOAD_TEXT</button></a>");
					if ($DM_VIEW_FILE){
						echo("<a href='$dir/$entry' target='$target' class='df_tda2'><button class='df_butt'>$L_VIEW</button></a>");
					}
					$entry2=$dir.'/'.$entry.$DM_TEXTFILE_EXT;
					if (file_exists($entry2)){
						echo("<br /><br />");
						include($entry2);
					}
					echo("</td>");
					$m=filectime($dir.'/'.$entry);
					$m=gmdate("Y.m.d", $m);
					echo("<td class='df_td2'>$m</td>");
					$m=filesize($dir.'/'.$entry);
					$m=formatBytes($m);
					echo("<td class='df_td2'>$m</td>");
					echo("</tr>");
				}
			}
        }
    }
}




if ($DM_LINK_TARGET_NEW_WINDOW){
    $target="_blank";
}else{
    $target="";
}

#echo("<div class=df_header>$L_DOWNLOAD_PAGE_HEAD</div>");

$dirnum=0;
$cardnum=0;

filetable($DM_DOC_ROOT);


?>

</div>


</body>
</html>

