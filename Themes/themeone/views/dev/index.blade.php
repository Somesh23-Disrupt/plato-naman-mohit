<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="shortcut icon" type="image/x-icon" href="{{themes('dev/devicon.png')}}">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="{{themes('dev/style.css')}}">

	</head>
	<body>

		<div class="login">
		    <div> <center> <a class="navbar-brand logo-image" href="index.html"><img src="{{themes('dev/devicon.png')}}" height="170" width="170" alt="PlatoDev"></a></center>
			</div>
			<h1>Developer Login</h1>
			<form action="dev" method="POST">
				{{ csrf_field() }}
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="email" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" value="Login">
			</form>
		</div>
	</body>
</html>
