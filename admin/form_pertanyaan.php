<?php
session_start();

?>
<html>
<head>
<title> form pendaftraan </title>
<style>

p.one
{
 border-style:solid;
 border-color:red;
}
p.two
{
 border-style:solid;
 border-color:#98bf21;
}
p
{
 border-top-style:dotted;
 border-right-style:dotted;
 border-bottom-style:dotted;
 border-left-style:dotted;
 
}
</style>
</head>
<body>
<form name="form1" method="post" enctype="" action="pertayaanaksi.php">
<center>
<marquee>
<text3D><marquee> Silahkan inputkan soal anda admin </text3D></marquee>
</marquee>
<table border="0"width="50%">
<tr><td colspan="4" align="center"><p class="two">MASUKAN  SOAL ADMIN </p></td></tr>
&nbsp; 
&nbsp; 
<tr><td>NO<td><td>:</td><td><input type="text" name="no"placeholder="kosongkan  saja"</td></tr>
<tr><td> soal <td><td>:</td><td>
<textarea name="soal" placeholder="Inputkan soal anda" rows ="4" cols="50">
</textarea>
<tr><td>a<td><td>:</td><td><input type="text" name="a"placeholder="Inputkan jawaban option A"</td></tr>
<tr><td>b<td><td>:</td><td><input type="text" name="b"placeholder="Inputkan jawaban option B"</td></tr>
<tr><td>c<td><td>:</td><td><input type="text" name="c"placeholder="Inputkan jawaban option c"</td></tr>
<tr><td>d<td><td>:</td><td><input type="text" name="d"placeholder="Inputkan jawaban option D"</td></tr>
<tr><td>kunci<td><td>:</td><td><input type="text" name="kunci"placeholder="Inputkan Kunci jawaban"</td></tr>
</td></tr>
</td></tr>
<tr><th colspan="4"><input type="submit" name="input" value="submit">
<input type="reset" name="input" value="reset">
</th></tr>
</table>
</center>
</form>
</center>
</body>

</html>
