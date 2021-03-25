<?php
if($_SESSION[email]==null)
	{
	echo "<script>alert('Silahkan Login Terlebih dahulu');window.location='media.php?page=home'</script>";
	}
?>
<?
$tgl = date("Y-m-d");
?>
<div id='judul_kontent'><h1><img src='images/status.png' width='30' height='30'> Laporan Pengunjung Hari ini</h1></div>
<table id='theList' border=1 width='100%'>
<tr><th>No.</th><th>Nama</th><th>email</th><th>Jenis kelamin</th><th>Tanggal Kunjungan</th><th>Waktu</th><th>Status</th></tr>
<?php

$sql = mysql_query("select *,count(pengunjung.id_acount) as jml from acount,pengunjung where acount.id_acount=pengunjung.id_acount and pengunjung.tgl='$tgl' group by pengunjung.id_acount order by pengunjung.id_acount asc ");
$no=1;
while($r = mysql_fetch_array($sql)){
if($r[aktif]==1){
$status="Online";
$gambar="online.ico";
}else{
$status="Offline";
$gambar="offline.ico";
}
?>
<tr>
<td class='td' align='center'><?echo$no;?></td>
<td class='td' width='30%'><?echo"$r[nm_depan] $r[nm_belakang]";?></td>
<td class='td'><?echo$r[email];?></td>
<td class='td'><?echo$r[jk];?></td>
<td class='td'><?echo tgl_indo($r[tgl]);?></td>
<td class='td'><?echo$r[waktu];?></td>
<td class='td' align='center' width='10%'><img src='images/<?echo$gambar;?>' width='15' height='15'> <?echo$status;?></td>
</tr>
<?
$no++;
$jml=$jml+$r[jml];
}
?>
</table>
<br>
<b>Jumlah Pengunjung Hari Ini : <?echo$jml;?></b>

<?
if($_GET[page]=='registrasi' and $_GET[act]=='delete'){
$sql=mysql_query("delete from acount where id_acount='$_GET[id]'");
echo"<script>window.location.href='?page=registrasi'</script>";
}

?>