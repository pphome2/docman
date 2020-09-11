<script>

function cardclose(th){
	//var x=document.getElementById(th);
	//var x=th.parentElement.parentElement.childNodes[2];
	if (th.style.display=='none'){
		th.style.display='block'
	} else {
		th.style.display='none'
	}
}


//Tab function for administration

function opentab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("card-body");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" activetab", "");
    }
    document.getElementById(tabName).style.display = "block";
    //document.getElementById(tabName).className += " active";
    evt.currentTarget.className += " activetab";
}


function delrow(obj){
	obj2=obj.parentNode;
	obj2.parentNode.style.display='none';
}

function cardclose2(th,th2){
	if (th.style.display=='none'){
		th.style.display='block';
		th2.innerHTML=' -- ';
	} else {
		th.style.display='none';
		th2.innerHTML=' + ';
	}
}



<?php
if (!$MA_USERPAGE){

if ($MA_ENABLE_COOKIES){
?>
setTimeout(function () { window.location.href = "<?php echo($MA_ADMINFILE); ?>"; }, <?php echo((($MA_LOGIN_TIMEOUT+1)*1000)); ?>);
<?php
}else{
?>
setTimeout(function () { window.location.href = "<?php echo($MA_ADMINFILE.'?'.$MA_COOKIE_STYLE.'='.$MA_STYLEINDEX); ?>"; }, <?php echo((($MA_LOGIN_TIMEOUT+1)*1000)); ?>);
<?php
}

}
?>

</script>
