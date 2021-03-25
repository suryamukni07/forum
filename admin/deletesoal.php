<?php  
include("./fungsi/koneksi.php");
$row = $_GET['no'];	
$sql=mysql_query("delete from t_soal where no='$_GET[no]'");

$result = mysql_query($sql);
if ($result)
{
echo "<script>window.alert('Data soal Berhasil Di Hapus !'); window.location ='media.php?page=soal'</script>";
	}
else
{
echo "<script>window.alert('Data berhasil Di Hapus !'); window.location ='media.php?page=soal'</script>";
}

?>
