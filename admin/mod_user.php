<?php
if($_SESSION[email]==null)
	{
	echo "<script>alert('Silahkan Login Terlebih dahulu');window.location='media.php?page=home'</script>";
	}
?>
<?php
switch($_GET[act]){
  // Tampil admin
  default:
    echo "<div id='judul_kontent'><h1><img src='images/Loging.png' width='30' height='30'> Admin</h1></div>
          <p align='left'><input  type=button value='Tambah Admin' onclick=location.href='?page=akun&act=tambahadmin'></p>
          <table id='theList' border=1 width='100%'>
          <tr><th>No</th>
		  <th>Username</th>
		  <th>Nama Lengkap</th>
		  <th>Email</th>
		  <th>No Telepon</th>
		  <th>aksi</th></tr>"; 
    $tampil=mysql_query("SELECT * FROM admin ORDER BY id asc");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr>
			 <td class=td align=center>$no</td>
             <td class=td> $r[username]</td>
             <td class=td> $r[nama_lengkap]</td>
		     <td class=td><a href=mailto:$r[email]>$r[email]</a></td>
			 <td class=td>$r[no_telp]</td>
			<td class=td align=center><a href='?page=akun&act=editadmin&id=$r[id]'><button style='width:60px;text-align:center;'>Edit</button></a> |
			<a href='./aksi.php?page=akun&act=delete&id=$r[id]'><button style='width:60px;text-align:center;'>Delete</button></a></td>
             </td></tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  case "tambahadmin":
    echo "<h2>&#187; Tambah admin</h2>
          <form method=POST action='./aksi.php?page=akun&act=input'>
          <table>
          <tr><td>Admin name</td>    <td> : <input type=text name='username'></td></tr>
          <tr><td>Password</td>     <td> : <input type=password name='password'></td></tr>
          <tr><td>Nama Lengkap</td> <td> : <input type=text name='nama_lengkap' size=30></td></tr>  
          <tr><td>E-mail</td>       <td> : <input type=text name='email' size=30></td></tr>
          <tr><td>No Telepon</td>   <td> : <input type=text name='no_telp' size=15></td></tr>
          <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form><br><br>";
     break;
    
  case "editadmin":
    $edit=mysql_query("SELECT * FROM admin WHERE id='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit admin</h2>
          <form method=POST action=./aksi.php?page=akun&act=update>
          <input type=hidden name=id value='$r[id]'>
          <table>
          <tr><td>Admin name</td>    <td> : <input type=text name='username' value='$r[username]'></td></tr>
          <tr><td>Password</td>     <td> : <input type=password name='password'> *)</td></tr>
          <tr><td>Nama Lengkap</td> <td> : <input type=text name='nama_lengkap' value='$r[nama_lengkap]' size=30></td></tr>  
          <tr><td>E-mail</td>       <td> : <input type=text name='email' value='$r[email]' size=30></td></tr>
          <tr><td>No Telepon</td>   <td> : <input type=text name='no_telp' value='$r[no_telp]' size=15></td></tr>
          <tr><td colspan=2>*) Apabila password tidak diubah, dikosongkan saja.</td></tr>
          <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
?>
