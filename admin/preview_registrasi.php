<?php
if($_SESSION[email]==null)
	{
	echo "<script>alert('Silahkan Login Terlebih dahulu');window.location='media.php?page=home'</script>";
	}
?>
<?
$page=$_GET[page];
$update=$_GET[update];
$act=$_GET[act];
$sql=mysql_query("select * from acount where id_acount='$_GET[id]'");
$r=mysql_fetch_array($sql);
$tgl=tgl_indo($r[tgl_lahir]);
?>
<div class="content_title_01"><h2>&#187; User Account</h2></div>
<div class='view'>
<table class='view' width='80%'>
<?
if(!empty($r[foto])){
echo"<div class='foto'><img src='../foto_acount/$r[foto]' width='130' height='160'></div>";
}else{
echo"<div class='foto'><img src='images/nofoto.jpg' width='130' height='160'></div>";
}
?>
<tr><td width='200'> No Registrasi</td><td>: <?echo $_GET[id];?></td></tr> 
<tr><td> Nama Lengkap</td><td>: <?echo"$r[nm_depan] $r[nm_belakang]";?></td></tr> 
<tr><td>Jenis Kelamin </td><td>: <?echo $r[jk];?></td></tr>
<tr><td>  Tanggal Lahir </td><td>: <?echo $tgl;?></td></tr>
<tr><td> E-mail</td><td>: <?echo$r[email];?></td></tr>				   
</table>  
</div>	                           

