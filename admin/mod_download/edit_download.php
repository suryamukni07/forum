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
$sql=mysql_query("select * from acount where id_acount='$_SESSION[id_acount]'");
$r=mysql_fetch_array($sql);

if ($page='edit_akun' AND $update=='ok'){
	//untuk memindahkan file ke tempat uploadan
	$upload_path = "foto_acount/";
	// handle aplikasi : apabila folder yang dimaksud tidak ada, maka akan dibuat
	if (!is_dir($upload_path)){
		mkdir($upload_path);
		opendir($upload_path);
	}
	$file = $_FILES['fupload']['name'];
	$tmp  = $_FILES['fupload']['tmp_name'];	
		
	if(empty($file)){
	$sql=mysql_query("update acount set     nm_depan='$_POST[nm_depan]',
											nm_belakang='$_POST[nm_belakang]',
											email='$_POST[email]',
											jk='$_POST[jk]',
											tgl_lahir='$_POST[tahun]-$_POST[bulan]-$_POST[tanggal]',
											email='$_POST[email]',
											password='$_POST[password]' where id_acount='$_SESSION[id_acount]'");
    }else{
	move_uploaded_file($tmp, $upload_path.$file);
	$sql=mysql_query("update acount set     nm_depan='$_POST[nm_depan]',
											nm_belakang='$_POST[nm_belakang]',
											email='$_POST[email]',
											jk='$_POST[jk]',
											tgl_lahir='$_POST[tahun]-$_POST[bulan]-$_POST[tanggal]',
											email='$_POST[email]',
											password='$_POST[password]',
											foto='$file' where id_acount='$_SESSION[id_acount]'");
	}
	?>
<center><img src='images/loading.gif' width='400' height='50'></div></center>		
<?			
		if($sql){				   
		?>  <br><br><center>
			<meta http-equiv='refresh' content='2;URL=?page=edit_akun'>
			</center>
			<?
		} else {
			$error = "<div style=\"font-size:14px;color:red\">Data Gagal Disimpan</div>";?>
			
			<meta http-equiv='refresh' content='2;URL=?page=edit_akun'>
			<?
		}
			//echo "<script>window.location = '?page=formulir'</script>";
}else{
?>
<div class="content_title_01">My Account</div>
<form method="post" action="?page=edit_akun&&update=ok" enctype='multipart/form-data' onSubmit="return validasi(this)">
<table width='100%'>
<?
if(!empty($r[foto])){
echo"<div class='foto'><img src='foto_acount/$r[foto]' width='130' height='160'></div>";
}else{
echo"<div class='foto'><img src='images/nofoto.jpg' width='130' height='160'></div>";
}
?>
<div>
<tr><td> ID Acount</td><td><input type='text' name='no_acount' value='<?echo $_SESSION[id_acount];?>' disabled></td></tr> 
<tr><td> Nama Lengkap</td><td><input type='text' name='nm_depan' value='<?echo $r[nm_depan];?>' ></td></tr> 
<tr><td> Nama Belakang</td><td><input type='text' name='nm_belakang' value='<?echo $r[nm_belakang];?>' ></td></tr> 
<tr><td> Email</td><td><input type='text' value='<?echo $r[email];?>' name='email'></td></tr> 
<tr><td> Password </td><td><input type='text' value='<?echo $r[password];?>' name='password'></td></tr> 
<tr><td height="48">Jenis Kelamin </td>
<?
$jk=$r[jk];
if($jk=='Laki-Laki'){
?>
<td>
<input name="jk" type="radio" checked value="Laki-Laki"/>Laki-Laki
<input name="jk" type="radio" value="Perempuan"/>Perempuan
</td>
<?
}else{
?>
<td>
<input name="jk" type="radio"  value="Laki-Laki"/>Laki-Laki
<input name="jk" type="radio" checked value="Perempuan"/>Perempuan
</td>
<?
}
?></tr>	
<?
$vtgl=substr($r[tgl_lahir],8,2);
$vbln=substr($r[tgl_lahir],5,2);
$vthn=substr($r[tgl_lahir],0,4);
if($vbln==1){$vnm_bln="Januari";}
else if($vbln==2){$vnm_bln="Februari";}
else if($vbln==3){$vnm_bln="Maret";}
else if($vbln==4){$vnm_bln="April";}
else if($vbln==5){$vnm_bln="Mei";}
else if($vbln==6){$vnm_bln="Juni";}
else if($vbln==7){$vnm_bln="Juli";}
else if($vbln==8){$vnm_bln="Agustus";}
else if($vbln==9){$vnm_bln="September";}
else if($vbln==10){$vnm_bln="Oktober";}
else if($vbln==11){$vnm_bln="November";}
else if($vbln==12){$vnm_bln="Desember";}
?>	
<tr><td> Tanggal Lahir </td><td>
					<?php
						echo "<select name=tanggal>
						<option value='$vtgl'>$vtgl</option>";
							for($no=1;$no<=31;$no++)
							{
								echo "<option value=$no>$no</option>";
							}
						echo "</select>";
						$nama_bln=array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
						echo "<select name=bulan><option value='$vbln'>$vnm_bln</option>";
							for($no=1;$no<=12;$no++)
							{
								echo "<option value=$no>$nama_bln[$no]</option>";
							}
						echo "</select>";
						$thn_skrg=date("Y");
						echo "<select name=tahun><option value='$vthn'>$vthn</option>";
							for($no=1980;$no<=$thn_skrg;$no++)
							{
								echo "<option value=$no>$no</option>"; 
							}
						echo "</select>";
					?> 
					
				</tr>
				   

<tr><td>Ganti Foto</td><td><input type='file' name='fupload'></td></tr>
<td></td>
<td><br><button type="submit" name="submit" ><img src="images/edit3.png" width='18' height='18' /> Update</button></td>
</tr>
</table>  
</div>	
</form>                            
<?}?>
