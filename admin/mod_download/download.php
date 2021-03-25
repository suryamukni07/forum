<?php
if($_SESSION[email]==null)
	{
	echo "<script>alert('Silahkan Login Terlebih dahulu');window.location='media.php?page=home'</script>";
	}
?>
<?
$page=$_GET[page];
$save=$_GET[save];
$act=$_GET[act];


if ($page='download' AND $save=='ok'){
$tgl=date('Ymd');
     if(empty($_POST[judul]) or empty($_POST[format])){
	 echo"<script>alert('Maaf, Data Anda Belum Lengkap !');window.location='?page=download'</script>";
	 }else{
	//untuk memindahkan file ke tempat uploadan
	$upload_path = "../files/";
	// handle aplikasi : apabila folder yang dimaksud tidak ada, maka akan dibuat
	if (!is_dir($upload_path)){
		mkdir($upload_path);
		opendir($upload_path);
	}
	$file = $_FILES['fupload']['name'];
	$tmp  = $_FILES['fupload']['tmp_name'];	
	move_uploaded_file($tmp, $upload_path.$file);	
	$sql=mysql_query("INSERT INTO download(judul,nama_file,format_file,tgl_posting) 
	VALUES('$_POST[judul]','$file','$_POST[format]','$tgl')");
	}
	?>
<div style=\"font-size:14px;color:red\"><img src='../images/loading.gif' width='400' height='50'><h3>Pelase Wait ...</h3></div>		
<?			
		if($sql){
		
		?>  <br><br><center>
			<meta http-equiv='refresh' content='2;URL=?page=download'>
			
			</center>
			<?
			echo "<script>alert('Data Sukses Disimpan !');javascript:history.go(-1) </script>";

		} else {
			$error = "<div style=\"font-size:14px;color:red\">Data Gagal Disimpan</div>";?>
			
			<meta http-equiv='refresh' content='2;URL=?page=download'><?
		}
			//echo "<script>window.location = '?page=formulir'</script>";
}else{
?>
<div class="content_title_01"><img src='../images/download.png' width='25' height='25'> <h3>&#187; Entry File Download</div>
<form method="post" action="?page=download&save=ok" enctype='multipart/form-data' onSubmit="return validasi(this)">
<table border="0" class="altrowstable1">
<div>
<tr><td> Judul </td><td><input type='text' size='50' name='judul'></td></tr> 
<tr><td height="48">Format File </td>
<td><select name='format'>
<option value=''>- Pilih Format File -</option>
<option value='EXCEL'>EXCEL</option>
<option value='PPT'>PPT</option>
<option value='MDB'>MDB</option>
<option value='EXE'>EXE</option>
<option value='RAR'>RAR</option>
<option value='PDF'>PDF</option>
<option value='DOC'>DOC</option>
</select>
</td></tr>		
<tr><td>File</td><td><input type='file' name='fupload'></td></tr>
<td></td>
<td><br><button type="submit" name="submit" ><img src="./images/simpan.png" width='20' height='20' /> Save</button>
&nbsp;<button type="reset" name="reset" ><img src="./images/prev.gif" width='20' height='20' /> Clear</button></td>
</tr>
</table>  
</div>	
</form>
			
                    
            

<?}?>
