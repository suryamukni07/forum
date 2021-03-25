<?php

    include 'koneksi.php';

    session_start();

    $jawab = $_SESSION['jawab'];

?>

<!DOCTYPE html>

<html>

<head>

    <title>Hasil Test</title>

</head>

<body>
<div style="font-family:verdana;padding:20px;border-radius:10px;border:10px solid #ffff00;">
<h1>&nbsp;</h1>
    <h1><center>Hasil Latihan pada forum pembelajaran Oniline  SMKN 2 Pariaman</center></h1>



   <table width="100%" border="1" cellspacing="2" cellpadding="1">

     <tr bgcolor="#FF9966">
            
           <th height="40" align="center" class="style5">NO</th>

            <th height="40" align="center" class="style5">Jawaban Anda</td>

            <th height="40" align="center" class="style5">Kunci Jawaban</td>

            <th height="40" align="center" class="style5">Status</td>

        </tr>

        <?php

            $i = 0;

            $benar = $salah = 0;

            $sql = mysql_query("select * from t_soal");

            while($key = mysql_fetch_array($sql)){

        ?>

        <tr>

            <td><?php echo $i+1; ?></td>

            <td><?php echo $jawab[$i] ?></td>

            <td><?php echo $key['kunci']; ?></td>

            <td>

                <?php

                    if ($jawab[$i] == $key['kunci']) {

                        echo "Benar";

                        $benar++;

                    }else{

                        echo "Salah";

                        $salah++;

                    }

                 ?>

            </td>

        </tr>

        <?php

                $i++;

            }

         ?>

    </table>

    <h3>Benar: <?php echo $benar; ?><br>

    Salah: <?php echo $salah; ?>	</h3>

    <a href="index.php">Kembali</a>
	<a href="index.php">menu awal</a>
    <a href="../media.php?page=home">home</a>
    									
 <h2>SCORE ANDA: <?php echo $_SESSION['score']; ?></h2>
<h1><?php echo"$_SESSION[namalengkap]";?></h1>

</body>

</html>