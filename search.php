<?php error_reporting(0); ?>
<head><title>Code for Job | Search</title>
<script type="text/javascript">
function getsearch(){
	var myBtn = document.getElementById('submit');
	//add event listener
	myBtn.addEventListener('click', function(event){
		var regno = document.getElementById('regno').value;
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById('result').innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","getsearch.php?search="+regno,true);
		xmlhttp.send();
	});
}
</script>
</head>

<body onLoad="getsearch()" background="bg.gif">
<img src="header.png" width="100%" height="30%" style="margin-top=-5px;">
<center>
<div  style="margin-top:50px;">
<input type="search" id="regno" /><br /><br />
<input type="image" src="b2.png" alt="Submit" id="submit" width="85px" height="30px">
<div id="result" style="margin-top:30px"></div>
</div></center>
</body>