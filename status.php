<?php
if($_SESSION[email]==null)
	{
	echo "<script>alert('Silahkan Login Terlebih dahulu');window.location='media.php?page=home'</script>";
	}
$waktu = Date("Y-m-d H:i:s");
$waktu1 = Date("H:i:s");
if(!isset($_GET[act]))
{

?>
<form  id='form-status' method='post' action="cek_status.php">
<b><div class='judul_status'><img src="images/status.png" width='20' height='20' >Status Terbaru :</div></b>
<textarea cols='100' rows='2' name='status' placeholder='Apa Yang Anda Pikirkan ?'></textarea><input type="hidden" name="waktu1" value="<?php echo $waktu1; ?>">
<input type="hidden" name="idacount1" value="<?php echo $_SESSION[id_acount]; ?>">
<p align='right'><button  type='submit' name='kirimstatus'  class='button green'><img src="images/status.png" width='20' height='20'/> Bagikan</button></p>
</form>
<?php
$sql="select * from status";
$res=mysql_query($sql,$con) or die(mysql_error());
while($datast=mysql_fetch_array($res))
	{
	$ids=$datast[id_status];
	$id=$datast[id_acount];
	$sql1="select * from acount where id_acount='".$id."'";
	$res1=mysql_query($sql1,$con) or die(mysql_error());
	$dataid=mysql_fetch_array($res1);
	$foto=$dataid[foto];
	?>
	<table border="0" class="altrowstable1">
	<Tr>
	<td rowspan="2"><img src="foto_acount/<?php echo $foto?>" width="80px"/></td>
	<form name="status" method="post" action="">
	<td width="85%"><strong><?php echo $dataid[nm_depan]; ?>&nbsp; <?php echo $dataid[nm_belakang]; ?>&nbsp;<?php echo $datast[waktu]; ?><input type="hidden" name="idstatus" value="<?php echo $datast[id_status]; ?>"> </strong></td>
	
	<td align="right">
	<?php
	if($datast[id_acount]==$_SESSION[id_acount])
	{
	?>
	<a href="media.php?page=status&act=del&id=<?php echo $datast[id_status] ?>">DELETE</a>
	<?php
	}
	?>
	</td>
	</tr>
	<tr>
	<Td colspan="2"><?php echo $datast[status]; ?></td>
	</tr>
	<?php
	$q4="select * from balas_status where id_status='".$ids."'";
	$res4=mysql_query($q4,$con) or die(mysql_error());
	while($data4=mysql_fetch_array($res4))
	{
	$q5="select * from acount where id_acount='$data4[id_acount]'";
	$res5=mysql_query($q5,$con) or die(mysql_error());
	$data5=mysql_fetch_array($res5);
	$foto3=$data5[foto];
	?>
	<Tr>
	<TD><img src="foto_acount/<?php echo $foto3?>" width="30px"/></TD>
	<Td><?php echo $data4[balas]; ?></td>
	</tr>
	<?php 
	}
	?>
	<?php
	$sql2="select * from acount where id_acount='$_SESSION[id_acount]'";
	$res2=mysql_query($sql2,$con) or die(mysql_error());
	$dataid2=mysql_fetch_array($res2);
	$foto2=$dataid2[foto];
	$id1=$dataid2[id_acount];
	?>
	<Tr>
	<Td><img src="foto_acount/<?php echo $foto2?>" width="30px"/><input type="hidden" name="ids" value="<?php echo $id; ?>"><input type="hidden" name="waktunya" value="<?php echo $waktu; ?>"><input type="hidden" name="ida" value="<?php echo $id1; ?>"></td>
	<td><textarea cols='45' rows='1' name='komen' placeholder='Komentari Status'></textarea>&nbsp;&nbsp;<input type="submit" name="kirimkomen" value="Komentari"></td>
	</tr>
	</form>
	</table>
	<?php

	}
		if($_POST[kirimkomen])
		{
		$qkomen="insert into balas_status values('','$_POST[idstatus]','$_POST[ida]','$_POST[komen]','$POST[waktunya]')";
		$reskomen=mysql_query($qkomen,$con) or die(mysql_error());
		if($reskomen)
			{
			echo "<script>window.location='media.php?page=status'</script>";
			}
		
		}
		
}else{
	if($_GET[act]=='del')
		{
			$sql1="delete from status where id_status='$_GET[id]'";
			$resq=mysql_query($sql1,$con) or die(mysql_error());
			if($resq)
				{
				echo "<script>alert('data terhapus');window.location='media.php?page=status'</script>";
				}
		
		}

}

?>