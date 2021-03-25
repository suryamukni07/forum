<?php
if($_SESSION[email]==null)
	{
	echo "<script>alert('Silahkan Login Terlebih dahulu');window.location='media.php?page=home'</script>";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Data Kategori</title>
<?php 
require("fungsi/koneksi1.php");
include("fungsi/autonumber.php");
?>
<style type="text/css">
    body { font-family:tahoma; font-size:12px; }
    #container { width:450px; padding:20px 40px; margin:50px auto; border:0px solid #555; box-shadow:0px 0px 2px #555; }
    input[type="text"] { width:200px; }
    input[type="text"], textarea { padding:5px; margin:2px 0px; border: 1px solid #777; }
    input[type="submit"], input[type="reset"],input[type="button"] { padding: 3px 15px; margin:2px 0px; font-weight:bold; cursor:pointer; }
 	#error { border:1px solid red; background:#ffc0c0; padding:5px; }
</style>
</head>
<body>
<?php
if(!isset($_GET[act]))
{
?>
<form name="form1" method="post" action="">
<p>Cari Sub Kategori &nbsp; : <input type="search" name="vkd" id="subkategori" placeholder="Kode Sub Kategori" autofocus /> &nbsp; <input type="submit" name="cari" value="CARI" />
</form> 
<table  width="100%" cellpadding="3" cellspacing="3" class="altrowstable" id="alternatecolor">
<tR>
<Th width="11%" align="left">Kode Sub Kategori</Th>
<Th width="19%" align="left">Nama Sub Kategori</Th>
<Th width="20%" align="left">Nama Kategori</Th>
<Th width="28%" align="left">Keterangan</Th>
<Th width="22%" >Aksi</Th>
</tR>
<?php
if($_POST[cari])
	{
		$kode=$_POST[vkd];		
		$q="Select kategori.kd_kategori,nm_kategori,sub_kategori.kd_subk,nm_subk,sub_kategori.ket,sub_kategori.kd_kategori from ".$prefix." sub_kategori,kategori where sub_kategori.kd_kategori=sub_kategori.kd_kategori and sub_kategori.kd_subk like '%".$kode."%'";
		$res=mysql_query($q,$con) or die(mysql_error());
	}else{
		$q="Select kategori.kd_kategori,nm_kategori,sub_kategori.kd_subk,nm_subk,sub_kategori.ket,sub_kategori.kd_kategori from ".$prefix." sub_kategori,kategori where sub_kategori.kd_kategori=kategori.kd_kategori";
		$res=mysql_query($q,$con) or die(mysql_error());
	}
	while($data=mysql_fetch_array($res))
		{
?>
<Tr>
<td><?php echo  $data[kd_subk]; ?></td>
<td><?php echo  $data[nm_subk]; ?></td>
<td><?php echo  $data[nm_kategori]; ?></td>
<td><?php echo  $data[ket]; ?></td>
<td align="center"><a href="media.php?page=subkategori&act=edit&kode=<?php echo $data[kd_subk]; ?>">EDIT </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="media.php?page=subkategori&act=del&kode=<?php echo $data[kd_subk]; ?>">HAPUS</a></td>
</Tr>
<?php
		}
?>
<Tr>
<Td colspan="14" align="right"><a href="media.php?page=subkategori&act=add"><img src="images/131.png" alt="tambah" /></a></Td>
</table>
<?php 
}else{	
	if($_GET[act]=='add')
	{
	?>
    <form name="tambahdatakategori" method="post" action="">
    <table width="100%" border="0" cellpadding="3" cellspacing="3"  class="altrowstable">
    <Tr>
    <th colspan="4">FORM INPUT DATA SUB KATEGORI</th>
    </tr>
    <tr>
    	<Td width="10%">Kode Sub Kategori</Td>
   	  <td width="90%"><input type="text" name="tt1" readonly value="<?php echo get_new_id("kd_subk","sub_kategori","SK-"); ?>" /> </td>
    </tr>
    <tr>
     <Td width="10%">Nama Sub Kategori</Td>
   	  <td width="90%"><input type="text" name="tt2" value="" placeholder="Nama Sub Kategori" autofocus/> </td>
    </tr>
     <tr>
     <Td width="10%">Kode Kategori</Td>
   	  <td width="90%">
     <select name="tt3" value="">
      <option disabled value="0">-=PILIH=-</option>
	  <?php
	  $q="select * from kategori";
	$res=mysql_query($q,$con) or die(mysql_error());
		while($data1=mysql_fetch_array($res))
		{
		?>
        <option value="<?php echo $data1[kd_kategori]; ?>"><?php echo $data1[nm_kategori]; ?></option>
		<?php 
		}  
	  ?>
     </select>
      </td>
    </tr>
      <tr>
     <Td width="10%">Keterangan</Td>
   	  <td width="90%"><textarea cols="45" rows="2" name="tt4" placeholder="Keterangan Sub Kategori"></textarea> </td>
    	</tr>
       <Tr>
    <td align="center" colspan="4"><input type="submit" name="simpan" value="SIMPAN" /> &nbsp; <input type="reset" name="reset" value="RESET" /> &nbsp; <input type="submit" name="batal" value="BATAL" /></td>    
    </tr>
    </table>
    </form> 
<?php 	
	if($_POST[simpan])
		{
		$t1=$_POST[tt1];
		$t2=$_POST[tt2];
		$t3=$_POST[tt3];
		$t4=$_POST[tt4];
	 $q="insert into sub_kategori values('".$t1."','".$t2."','".$t3."','".$t4."')";
	 $res=mysql_query($q,$con) or die(mysql_error());
	if($res)
		{
		echo "<script>alert('Data Tersimpan');window.location='media.php?page=subkategori';</script>";
		}	
	}
	if($_POST[batal])
		{
		echo "<script>window.location='media.php?page=subkategori';</script>";
		}
	}	
?>
<?php
	if($act=='del')
	{
	$q="delete from sub_kategori where kd_subk='$_GET[kode]'";
	$res=mysql_query($q,$con) or die(mysql_error());
	if ($res)
		{
		echo "<script>alert('Data Berhasil Dihapus');window.location='media.php?page=subkategori';</script>";
		}
	}

?>
<?php
	if($_GET[act]=='edit')
	{
	$q="Select kategori.kd_kategori,nm_kategori,sub_kategori.kd_subk,nm_subk,sub_kategori.ket,sub_kategori.kd_kategori from ".$prefix." sub_kategori,kategori where sub_kategori.kd_kategori=kategori.kd_kategori and sub_kategori.kd_subk='$_GET[kode]'";
	$res=mysql_query($q,$con) or die(mysql_error());
	$data=mysql_fetch_array($res);
?>	
	  <form name="ubahdatasubkategori" method="post" action="">
    <table width="100%" border="0" cellpadding="3" cellspacing="3"  class="altrowstable">
    <Tr>
    <th colspan="4">FORM INPUT DATA SUB KATEGORI</th>
    </tr>
    <tr>
    	<Td width="10%">Kode Sub Kategori</Td>
   	  <td width="90%"><input type="text" name="tt1" readonly value="<?php echo $data[kd_subk]; ?>" /> </td>
    </tr>
    <tr>
     <Td width="10%">Nama Sub Kategori</Td>
   	  <td width="90%"><input type="text" name="tt2" value="<?php echo $data[nm_subk]; ?>" placeholder="Nama Sub Kategori" autofocus/> </td>
    </tr>
     <tr>
     <Td width="10%">Kode Kategori</Td>
   	  <td width="90%">
     <select name="tt3" value="">
      <option disabled value="0">-=PILIH=-</option>
	  <option  value="<?php echo $data[kd_kategori]; ?>"><?php echo $data[nm_kategori]; ?></option>
	  <?php
	  $q="select * from kategori";
	$res=mysql_query($q,$con) or die(mysql_error());
		while($data1=mysql_fetch_array($res))
		{
		?>
        <option value="<?php echo $data1[kd_kategori]; ?>"><?php echo $data1[nm_kategori]; ?></option>
		<?php 
		}  
	  ?>
     </select>
      </td>
    </tr>
    <tr>
    <td>Keterangan</td>
  <td>  <textarea cols="45" rows="2" name="tt4" placeholder="Keterangan Sub Kategori"><?php echo $data[ket]; ?></textarea></td>
       </tr>
       <Tr>
    <td align="center" colspan="4"><input type="submit" name="ubah" value="UBAH" /> &nbsp; <input type="reset" name="reset" value="RESET" /> &nbsp; <input type="submit" name="batal" value="BATAL" /></td>    
    </tr>
    </table>
    </form> 
	
<?php
	if($_POST[ubah])
		{
		$t1=$_POST[tt1];
		$t2=$_POST[tt2];
		$t3=$_POST[tt3];
		$t4=$_POST[tt4];
		$q="update sub_kategori set nm_subk='".$t2."',kd_kategori='".$t3."',ket='".$t4."' where kd_subk='".$t1."'";
		$res=mysql_query($q,$con) or die(mysql_error());
		if($res)
			{
			echo "<script>alert('Data Berhasil Di Ubah');window.location='media.php?page=subkategori';</script>";
			}
		}
		if($_POST[batal])
		{
		echo "<script>window.location='media.php?page=subkategori';</script>";
		}
	}
?>
<?php

}
?>
</body>
</html>
