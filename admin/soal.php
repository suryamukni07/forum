<?
include "fungsi/koneksi.php";

$download=mysql_query("select * from t_soal");
$cek=mysql_num_rows($download);

if($cek){
	
	?>
	<h2 align="center">Data - Data Soal Forum Pembelajaraan Online SMKN 2 Paraiman </h2>
		
	<table class="datatable" align="center">
		<tr>        
			<th width="10%" scope="col">nomor</th>
            <th width="6%" scope="col">soal</th>
            <th width="12%">A</th>
            <th width="12%">B</th>
            <th width="13%">C</th> 
            <th width="21%">D</th>            			
            <th width="26%">jawaban</th>     
         
            <th width="46%">Hapus <a link href="deletesoal.php?no="<?php echo $hapus[no]?></th>
            
            
            
            
            
	  </tr>        
        
	<?
	while($row=mysql_fetch_array($download)){
		?>
		<tr>
			
            <td><?=$row['no'];?></td>
            <td><?=$row['soal'];?></td>
            <td><?=$row['a'];?></td>
            <td><?=$row['b'];?></td>
			<td><?=$row['c'];?></td>
            <td><?=$row['d'];?></td>
            <td><?=$row['kunci'];?></td>
            
            
            <td><a href="deletesoal.php?no=<? echo $row['no']; ?>">Hapus</a></td>
           
                                             
                     
           			
		</tr>
		<?
	}
	?>
</table>
	<?
	
}else{
	echo "<font color=red><center><b>Belum Ada Data!!</b><center</font>";
}


?>