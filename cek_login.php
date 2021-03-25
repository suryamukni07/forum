<?php
include "fungsi/koneksi.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$username = anti_injection($_POST['user']);
$pass     = anti_injection($_POST['password']);
$pass=md5($_POST['password']);
$pass_user     = anti_injection($_POST['password']);

$level=$_POST['level'];
if($level=='admin'){
$login=mysql_query("SELECT * FROM admin WHERE username='$username' AND password='$pass' ");
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);
// Apabila username dan password ditemukan
if ($ketemu > 0){
  session_start();
  $_SESSION[namauser]     = $r[username];
  $_SESSION[namalengkap]  = $r[nama_lengkap];
  $_SESSION[passuser]     = $r[password];
  $_SESSION[leveluser]    = $level;
  $_SESSION[email]		  = $r[email];  
  $sid_lama = session_id();
  session_regenerate_id();
  $sid_baru = session_id();
  mysql_query("UPDATE admin SET id_session='$sid_baru' WHERE username='$username'");
  header('location:./admin/media.php?page=home');
}
else{
  echo "<script>alert('Maaf, Password Dan Username Anda Tidak Benar, atau account anda sudah di blokir !');javascript:history.go(-1) </script>";
}
}else{
$login=mysql_query("SELECT * FROM acount WHERE email='$username' AND password='$pass_user' ");
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);
// Apabila username dan password ditemukan
if ($ketemu > 0){
  session_start();
  $_SESSION[id_acount]    = $r[id_acount];
  $_SESSION[namalengkap]  = "$r[nm_depan] $r[nm_belakang]";
  $_SESSION[namadepan]	  =$r[nm_depan];
  $_SESSION[namabelakang] =$r[nm_belakang];
  $_SESSION[passuser]     = $r[password];
  $_SESSION[foto]    	  = $r[foto];
  $_SESSION[leveluser]    = $level;
  $_SESSION[email]		  = $r[email];
  $sid_lama = session_id();
  session_regenerate_id();
  $sid_baru = session_id();
  $waktu = date("H:i:s");
  $tgl = date("Y-m-d");
  mysql_query("insert into pengunjung (id_acount,waktu,tgl) values ('$_SESSION[id_acount]','$waktu','$tgl') ");
  mysql_query("update acount set aktif='1' WHERE id_acount=' $_SESSION[id_acount]' ");
  header('location:media.php?page=home');
}
else{
  echo "<script>alert('Maaf, Password Dan Username Anda Tidak Benar, atau account anda sudah di blokir !');javascript:history.go(-1) </script>";
}
}

?>
