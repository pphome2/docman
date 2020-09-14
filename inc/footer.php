<?php

 #
 # MiniApps - framework
 #
 # info: main folder copyright file
 #
 #

?>

</div>

<?php
    $nextstyle=$MA_STYLEINDEX+1;
    if ($nextstyle>(count($MA_CSS)-1)){
		$nextstyle=0;
    }

    if (($MA_ENABLE_COOKIES)and(!$MA_LOGGEDIN)and(!$MA_PRIVACY_PAGE)){
		echo("<p class=padleft>$L_COOKIE_TEXT <a class=\"privacybutton\" href=\"$MA_PRIVACY\">$L_PRIVACY_MENU</a></p>");
    }

?>



<footer>

    <ul class="sidenav">
	<li class="padleft"><?php echo($MA_COPYRIGHT); ?></li>

<?php

if ($MA_ENABLE_COOKIES){

?>
    <li class="liright">
		<a href="" onclick="document.cookie='<?php echo($MA_COOKIE_STYLE.'='.$nextstyle); ?>;return false;' "><?php echo($L_THEME); ?></a>
    </li>
    <li class="liright">
		<a href="<?php echo($MA_PRIVACY) ?>" ><?php echo($L_PRIVACY_MENU); ?></a>
    </li>
<?php

}else{

?>
    <li class="liright">
		<a href="<?php echo($MA_ADMINFILE."?".$MA_STYLEPARAM_NAME."=".$nextstyle); ?>"><?php echo($L_THEME); ?></a>
    </li>
    <li class="liright">
		<a href="<?php echo($MA_PRIVACY."?".$MA_STYLEPARAM_NAME."=".$$MA_STYLEINDEX) ?>" ><?php echo($L_PRIVACY_MENU); ?></a>
    </li>


<?php

}
	echo("<li class=\"liright\">");

	if ($MA_LOGGEDIN){
		echo("<a href=#
			onclick=\"document.cookie='$MA_COOKIE_PASSWORD=$L_LOGOUT; expires=Thu, 01 Jan 1970 00:00:00 UTC;';window.location = window.location.href;\">$L_LOGOUT</a>");
	}
	
?>

	</li>
	</ul>

</footer>

</body>
</html>
