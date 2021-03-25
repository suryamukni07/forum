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
<link href="css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
$date = Date("Y-m-d H:i:s");
$email= $_SESSION[email];
?>
<?php
if(!isset($_GET[act]))
{
?>
    <table  width="100%" cellpadding="3" cellspacing="3" class="altrowstable" id="alternatecolor">
    <tr>
    <th colspan="7"><h2>FORUM DISKUSI PELAJAR SMKN 2 PARIAMAN</h2></th>
    </tr>
    <TR>
    
    <Th colspan="2">Nama Kategori</Th>
    <Th width="13%">Total Post</Th>
    </TR>
    <?PHP
    
    $q="select * from kategori order by kd_kategori";
    $res=mysql_query($q,$con)or die(mysql_error());
    while($data=mysql_fetch_array($res))
    {
    $kodekategori=$data[kd_kategori];
    ?>
    <Tr>
    <td width="6%" rowspan="2" align="center"><img src="images/edit3.png" width='20' height='20' /></td>
    </Tr>
    <Tr>
    <td width="81%" align="left"><h3><?php echo $data[nm_kategori]; ?></h3>"<?php echo $data[ket]; ?>" <br />
    <?php 
    $q2="select * from sub_kategori where kd_kategori='".$kodekategori."'";
    $res2=mysql_query($q2,$con) or die(mysql_error());
    while($data2=mysql_fetch_array($res2))
    	{
    	?>
    		<a href="media.php?page=diskusi&act=detail&subkat=<?php echo $data2[kd_subk]; ?>"><font color="#FF0000"><u><?php echo $data2[nm_subk]; ?></u></font></a>
    	<?php 
    	}
     	?>
    </td>
    <td><?php 
$no=0;
	$sql="";
	$qtpost="SELECT kategori.kd_kategori,sub_kategori.kd_subk,posting.kd_subk FROM kategori INNER JOIN sub_kategori ON kategori.kd_kategori = sub_kategori.kd_kategori INNER JOIN posting ON sub_kategori.kd_subk = posting.kd_subk where kategori.kd_kategori='$data[kd_kategori]'";
$restpost=mysql_query($qtpost,$con) or die(mysql_error());
while($dtpost=mysql_fetch_array($restpost))
{
$no=$no+1;
}
echo $no;
	?> </td>
    </Tr>
    <?php 
    }
    ?>
    </table>
<?php 
}else{
	if($_GET[act]=='detail')
	{
	
	if(!isset($_GET[aksi]))
	{
	$q="select * from sub_kategori where kd_subk='$_GET[subkat]'";
	$res=mysql_query($q,$con) or die(mysql_error());
	$data=mysql_fetch_array($res);
	$subkategori=$data[kd_subk];
	?>
    <a href="media.php?page=diskusi&act=detail&subkat=<?php echo $_GET[subkat]; ?>&aksi=newpost"><img src="images/i_post.png" /></a>
    <table border="1" width="100%" cellpadding="2" cellspacing="3" class="altrowstable" id="alternatecolor">
    <tr>
    <Th colspan="7"><font color="#0066FF" size="+1">.:: &nbsp;<?php echo $data[ket]; ?>&nbsp;::.</font></Th>
    </tr>
    <tr>
    <th>Topik</th>
    <th>Pengirim</th>
    <th>Waktu Post</th>
	    </tr>
    <?php
	$sql1="select * from posting where kd_subk='$_GET[subkat]' order by id_post ";
	$res1=mysql_query($sql1,$con) or die(mysql_error());
	while($data1=mysql_fetch_array($res1))
	{
	?>
    <Tr>
    <Td><a href="media.php?page=diskusi&act=detail&subkat=<?php echo $_GET[subkat]; ?>&aksi=viewpost&idpost=<?php echo $data1[id_post]; ?>"><h3><font color="#0066FF"><?php echo $data1[judul]; ?></font></h3></a></Td>
     <Td><?php echo $data1[id_acount]; ?></Td>
    <Td><?php echo $data1[waktu_post]; ?></Td>
    </Tr>
    <?php
	}
	?>
    </table>
	<?php 
	}else{
		if($_GET[aksi]=='newpost')
		{
		?>
        <form name="newpost" method="post" action="" enctype="multipart/form-data">
        <table border="1" width="100%" cellpadding="3" cellspacing="2" class="altrowstable">
        <tr>
        <th colspan="2">KIRIM TOPIK BARU</th>
        </tr>
        <tr>
        <td><b>Title of the Topic</b></td>
        <Td><input type="text" name="judul" value="" placeholder="Judul Topik" autofocus  required /></Td>
        </tr>
        <tr>
        <td valign="top"><b>Isi Pesan</b></td>
        <Td><textarea cols="100" rows="20" name="isi"></textarea></Td>
        </tr>
        <tr>
        <td><b>Attach File</b></td>
        <td><input type="file" name="fupload" /><input type="hidden" name="waktu_post" value="<?php echo $date; ?>" /><input type="hidden" name="email" value="<?php echo $email; ?>" /><input type="hidden" name="sub_kategori" value="<?php echo $_GET[subkat] ?>" /></td>
        </tr>
        <tr>
        <td colspan="2" align="center"><input type="submit" name="kirim" value="KIRIM" /><input type="submit" name="kembali" value="KEMBALI" /><input type="reset" name="reset" value="RESET" /></td>
        </tr>
        </table>
        </form>
        <?php 
		if($_POST[kembali])
			{
				echo "<script>window.location='media.php?page=diskusi&act=detail&subkat=$_GET[subkat]'</script>";	
			}
		if($_POST[kirim])
			{
			//untuk memindahkan file ke tempat uploadan
			$upload_path = "files/";
			// handle aplikasi : apabila folder yang dimaksud tidak ada, maka akan dibuat
			if (!is_dir($upload_path)){
				mkdir($upload_path);
				opendir($upload_path);
			}
			$file = $_FILES['fupload']['name'];
			$tmp  = $_FILES['fupload']['tmp_name'];	
			move_uploaded_file($tmp, $upload_path.$file);	
			$sql="insert into posting values('','$_POST[sub_kategori]','$_POST[email]','$_POST[judul]','$_POST[isi]','$file','$_POST[waktu_post]')";
			$res=mysql_query($sql,$con) or die(mysql_error());
			if($res)
				{
				echo "<script>alert('Topik Berhasil Terkirim');window.location='media.php?page=diskusi&act=detail&subkat=$_GET[subkat]'</script>";
				}
			//bataas
			}
				
		}
		else if($_GET[aksi]=='viewpost')
			{
			$sql="";
			$sql="select * from posting where id_post='$_GET[idpost]'";
			$resview=mysql_query($sql,$con) or die(mysql_error());
			$dataview=mysql_fetch_array($resview);
			$mail=$dataview[id_acount];
			?>
			<form name="newpost" method="post" action="" enctype="multipart/form-data">
        <table border="1" width="100%" cellpadding="3" cellspacing="2" class="altrowstable">
               <tr>
        <Td colspan="3" align="center"><h3><font color="#0033FF">.:: <?php echo $dataview[judul]; ?>::. </font></h3></Td>
        </tr>
        <tr>
        <td valign="top"><b>Pengirim</b></td>
        <td>Message</td>
        </tr>
        <Tr>
        <td valign="top"><?php
		if($_SESSION[leveluser]=='admin')
	{
      $qviewsender="select * from admin where email='".$mail."' ";
	}else{
		$qviewsender="select * from acount where email='".$mail."'";
	}
		$resviewsender=mysql_query($qviewsender,$con) or die(mysql_error());
		$dataview1=mysql_fetch_array($resviewsender);
		$namafoto=$dataview1[foto];
		?>
        <img src="foto_acount/<?php echo $namafoto;  ?>" width="150px" />
		</td>
        <Td><textarea cols="100" rows="20" name="isi" readonly><?php echo $dataview[isi]; ?></textarea></Td>
        </tr>
        <tr>
        <td><b>Attach File</b></td>
        <td><a href="files/<?php echo $dataview[file]; ?>"><?php echo $dataview[file]; ?></a><input type="hidden" name="waktu_post" value="<?php echo $date; ?>" /><input type="hidden" name="email" value="<?php echo $email; ?>" /><input type="hidden" name="sub_kategori" value="<?php echo $_GET[subkat] ?>" /></td>
        </tr>
        </table>
        </form>
        <br />
        <br />
        <h3>KOMENTAR</h3>
        <form name="komentarpost" action="" method="post">
        <table border="1" width="100%" class="altrowstable">
        <tr>
        <td>Email</td>
        <td><?php echo $email; ?><input type="hidden" name="idacount" value="<?php echo $email; ?>" /><input type="hidden" name="waktu_komen" value="<?php echo $date; ?>" /></td>
        </tr>
        <Tr>
        <td>Isi Komentar</td>
        <td valign="middle"><textarea cols="45" rows="3" name="isi" ></textarea> &nbsp;&nbsp; <input type="submit" name="kirimkomen" value="KIRIM" />
</td>
			</Tr>
        </table>
        </form>
        <table border="0" width="100%" class="altrowstable1">
        <?php
		$qviewkomen="select * from komentar where id_post='$_GET[idpost]'";
		$res2=mysql_query($qviewkomen,$con) or die(mysql_error());
		while($datakomen=mysql_fetch_array($res2))
			{
			$email=$datakomen[id_acount];
			$qfoto="select * from acount where email='$email'";
			$resfoto=mysql_query($qfoto,$con) or die(mysql_error());
			$datafoto=mysql_fetch_array($resfoto);
		?>
        <tr>
        <td width="7%" rowspan="4"><img src="foto_acount/<?php echo $datafoto[foto]; ?>" width="50px" /></td>
        </Tr>
        <Tr>
        <Td width="93%"><?php echo $datakomen[id_acount]; ?></Td>
        </Tr>
        <tr>
        <Td><?php echo $datakomen[waktu_komen]; ?></Td>
        </tr>
        <tr>
        <Td><strong> <font size="2"><?php echo $datakomen[isi]; ?></font></strong></Td>
        </Tr>

        <?php
			}
		?>
        </table>
        <?php
		if($_POST[kirimkomen])
			{
			$sql="INSERT INTO `komentar` (`idkomen`, `id_post`, `id_acount`, `isi`, `waktu_komen`) VALUES ('', '$_GET[idpost]', '$_POST[idacount]', '$_POST[isi]', '$_POST[waktu_komen]')";
			$res1=mysql_query($sql,$con) or die(mysql_error());
			if($res1)
				{
				echo "<script>window.location='media.php?page=diskusi&act=detail&subkat=$_GET[subkat]&aksi=viewpost&idpost=$_GET[idpost]'</script>";
				}
			} 
		}
	}
	?>
	
	

    <?php 
	
	}

}
?>
</body>
</html>
