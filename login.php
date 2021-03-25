<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Custom Login Form Styling with CSS3" />
        <meta name="keywords" content="css3, login, form, custom, input, submit, button, html5, placeholder" />
        <meta name="author" content="Codrops" />
    </head>
    <body>
<form class="form-2" method="post" action="cek_login.php">
					<h1><span class="log-in">login</span> Sistem Forum <span class="sign-up">siswa/i</span></h1>
					<p class="float">
						<label for="login"><i class="icon-user"></i>Username</label>
						<input type="text" name="user" placeholder="Username or email">
				<br>
						<label for="level"><i class=""></i>	Level</label>
						<select name="level"><option value=''>Pilih Level Login Anda !</option>
						<option value="admin">Admin</option>
						<option value="user">Siswa/i</option>
			
						</select>
				<br>
		
						<label for="password"><i class="icon-lock"></i>Password</label>
						<input type="password" name="password" placeholder="Password" class="showpassword">
					</p>
					<p class="clearfix"> 
						<a href="./media.php?page=registrasi" class="log-twitter">Registrasi</a>    
						<input type="submit" name="login" value="Log in">
					</p>
				</form>

				