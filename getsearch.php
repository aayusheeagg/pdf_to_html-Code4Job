<?php
error_reporting(0);
$link = mysqli_connect("localhost", "root", "", "code4job") or die(mysqli_error());

if(isset($_GET['search']))
{
	$search = mysqli_real_escape_string($link, $_GET['search']);
	$query = mysqli_query($link, "SELECT * FROM data WHERE regno=".$search);
	if(mysqli_num_rows($query) != 0)
	{
		$row = mysqli_fetch_assoc($query);
?>
		<form>
		<fieldset style="width:45%"><legend>Search Result</legend>
		<table>
		<tr><td width="20%">Registration No.: </td><td width="60%"><?php echo $search; ?></td>
		<td rowspan="4">
<?php	if(file_exists("logos/$search.jpg")){ ?>
		<img src="logos/<?php echo $search; ?>.jpg" width="120px" height="80px" >
<?php	}
		else
			echo '<b>'.$row['altLogo'].'</b>'; ?>
		</td></tr>
		<tr><td>Class: </td><td><?php echo $row['class']; ?></td></tr>
		<tr><td>Company Name: </td><td><?php echo $row['name']; ?></td></tr>
		<tr><td>Address: </td><td><?php echo $row['address']; ?></td></tr>
		</tr>
		</table>
		</fieldset>
		</form>
<?php
	}
	else
		echo 'Nothing Found';
}
else
	echo 'Nothing Found';
	
mysqli_close($link);
?>