<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form name="form1" method="post" enctype="" action="pertayaanaksi.php">
<center>
<marquee>
<h1><b> Silahkan inputkan soal anda admin</b> </h1>
</marquee>
<table border="0"width="50%">
<tr><td colspan="4" align="center"><p class="two">MASUKAN  SOAL ADMIN </p></td></tr>
&nbsp; 
&nbsp; 
<tr><td>NO<td><td>:</td><td><input type="text"value="<? echo $data['no']; ?>" name="no"</td></tr>
<tr><td> soal <td><td>:</td><td>
<textarea name="soal" rows ="4" cols="50">
</textarea>
<tr><td>a<td><td>:</td><td><input type="text" <? echo $data['soal']; ?> name="a"</td></tr>
<tr><td>b<td><td>:</td><td><input type="text" name="b"</td></tr>
<tr><td>c<td><td>:</td><td><input type="text" name="c"</td></tr>
<tr><td>d<td><td>:</td><td><input type="text" name="d"</td></tr>
<tr><td>kunci<td><td>:</td><td><input type="text" name="kunci"</td></tr>
</td></tr>
</td></tr>
<tr><th colspan="4"><input type="submit" name="input" value="submit">
<input type="reset" name="input" value="reset">
</th></tr>
</table>
</center>
</form>
</body>
</html>