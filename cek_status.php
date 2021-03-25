<?php
include "fungsi/koneksi.php";
mysql_query("INSERT INTO status(id_acount,status,waktu)VALUES('$_POST[idacount1]','$_POST[status]','$_POST[waktu1]')");
echo"<script>window.location='media.php?page=status'</script>";
?>