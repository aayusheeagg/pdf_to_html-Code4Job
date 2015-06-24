<?php
error_reporting(0);
exec("rd/s/q uploads");
exec("rd/s/q data");
exec("md uploads");
if ($_FILES["file"]["error"] > 0)
	echo "Error: " . $_FILES["file"]["error"] . "<br>";
else
{
	move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/" . $_FILES["file"]["name"]);
}
exec("md data");
exec("md logos");
exec("pdftohtml uploads/" . $_FILES["file"]["name"] ." data\\data.html", $output);

$f = strip_tags(file_get_contents("data\\datas.html"),'<br><hr>');
$pages = explode('<hr>',$f);
array_pop($pages);
$entry = 0;
$duplicate = 0;
$link = mysqli_connect("localhost", "root", "", "code4job") or die(mysqli_error());

foreach($pages as $pgno=>&$page)
{
	$page = explode('<br>',$page);
	$page = array_filter($page, 'removeEmptyElements');
	$page = array_values($page);
	
	$line = 0;
	
	$class = '';
	$regno = '';
	$alttext='';
	$name='';
	$address='';
	
	$class = substr(stristr($page[$line++],'Class '),5);
	for(;$line<count($page);)
	{
		if (stripos($page[$line++], 'Advertised before') !== false)
			break;
	}
	for($i=1;$i<$line-1;$i++)
		$alttext=$page[$i].'<br>';
	$alttext=trim($alttext,'<br>');
	if($line<count($page))
		list($regno)=explode(' ',$page[$line++]);
	
	if($regno != '' && $class != ''){
		$query = mysqli_query($link, "SELECT * FROM data WHERE regno=".$regno);

		if(mysqli_num_rows($query) == 0){
			
			for($i=$line;$i<count($page);$i++)
			{
				if (stripos($page[$i], 'trading as ') !== false)
				{
					break;
				}
			}
			
			if($i<count($page))
			{
				$line=$i;
				$name=substr(stristr($page[$line++],'trading as  '),10);
			}
			else
				$name=$page[$line++];
			if($line<count($page))
				$address=$page[$line++];
			
			if(!preg_match("/Merchant|Manufacture|Market|Product|Trader|Parts|Trading|Retail|Address for/i",$page[$line]))
					$address = $address.'<br>'.$page[$line];
			
			@rename("data/data-".($pgno+1)."_1.jpg","logos/".$regno.".jpg");
			$query = mysqli_query($link, "INSERT INTO data VALUES(".$regno.", '$class', '$alttext', '$name', '$address')");
			$entry++;
		}
		else
			$duplicate++;
	}
}
mysqli_close($link);
function removeEmptyElements($var)
{
	return trim($var) != "" ? trim($var) : null;
}
exec("rd/s/q uploads");
exec("rd/s/q data");
?>
<script>alert("<?php echo $entry; ?> entries found. <?php echo $duplicate; ?> duplicate entries found.");
window.location="search.php";</script>