<?php
if($_SESSION[email]==null)
	{
	echo "<script>alert('Silahkan Login Terlebih dahulu');window.location='media.php?page=home'</script>";
	}
?>
<div id='judul_kontent'><h1><img src='images/registrasi.png' width='30' height='30'> Data Registrasi</h1></div>
<table id='theList' border=1 width='100%'>
<tr><th>No.</th><th>Nama</th><th>email</th><th>jenis kelamin</th><th>Tanggal lahir</th><th>Status</th><th>Aksi</th></tr>
<?php
$sql = mysql_query("select * from acount order by id_acount asc");
$no=1;
while($r = mysql_fetch_array($sql)){
if($r[aktif]==1){
$status="Online";
}else{
$status="Offline";
}
?>
<tr>
<td class='td' align='center'><?echo$no;?></td>
<td class='td' width='30%'><?echo"$r[nm_depan] $r[nm_belakang]";?></td>
<td class='td'><?echo$r[email];?></td>
<td class='td'><?echo$r[jk];?></td>
<td class='td'><?echo$r[tgl_lahir];?></td>
<td class='td' align='center' width='10%'><?echo$status;?></td>
<td class='td' align='center' width='18%'>
 <a  href='?page=registrasi&act=delete&id=<?echo$r[id_acount];?>' onclick="return confirm('Anda yakin untuk menghapus data ini ?')"><button style='width:60px;text-align:center;'>Delete</button></a> |
 <button onclick=location.href='?page=preview_registrasi&id=<?echo$r[id_acount];?>' style='width:60px;text-align:center;'>Preview</button></td>
</tr>
<?
$no++;
}
?>
</table>

<?
if($_GET[page]=='registrasi' and $_GET[act]=='delete'){
$sql=mysql_query("delete from acount where id_acount='$_GET[id]'");
echo"<script>window.location.href='?page=registrasi'</script>";
}

?>