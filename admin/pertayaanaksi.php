<?php
include "fungsi/koneksi.php";	
$no	= $_POST['no'];
$soal		= $_POST['soal'];
$a	= $_POST['a'];
$b		= $_POST['b'];
$c		= $_POST['c'];
$d		= $_POST['d'];
$kunci		= $_POST['kunci'];

$sql	="insert into t_soal values('$no',
								 '$soal',
								 '$a',
								 '$b',
								 '$c',
								 '$d',
								 '$kunci')";
$result = mysql_query($sql);
if($result){
    echo "<script type='text/javascript'>
		alert('Data Berhasil Disimpan...!!!');
    </script>";
	echo "<meta http-equiv='refresh' content='0; url=http://localhost/Forum_surya/admin/media.php?page=soal'>";
	
}else{
echo "<script type='text/javascript'>
	onload =function(){
	alert('Data Gagal Disimpan...!!!');
		}
	</script>";
}
?>