<html>
<head>
</head>
<body>
<form class="form-22" method="post" action="">
<div id='judul_header'>&#187; Jam </div>
<center><embed src="images/matsclock-1071_analog_clock.swf"  width="200" height="160" type="application/x-shockwave-flash"></center>

<div id='judul_header'>&#187; Kalender</div>
<div class='agenda'> 
  <?php 
  $tgl_skrg=date("d");
  $bln_skrg=date("n");
  $thn_skrg=date("Y");
  
 echo buatkalender($tgl_skrg,$bln_skrg,$thn_skrg); 
  ?>
  
</div>
</form>
</body>
</html>