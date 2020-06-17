<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link rel="shortcut icon" type="image/x-icon" href="{{themes('dev/devicon.png')}}">
		<link rel="stylesheet" href="{{themes('dev/style.css')}}">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
			    <a class="navbar-brand logo-image" href=""><img src="{{themes('dev/logo.png')}}" height="80" width="90" alt="alternative"></a>
				<h1>Team TOTBOX</h1>
				<a href="dev_home"><i class="fas fa-home"></i>Home</a>
				<a href="dev_users"><i class="fas fa-users"></i>Subscribed Users</a>
				<a href="dev_profile"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td>{{Auth::user()->username}}</td>
					</tr>
					<tr>
						<td>Password:</td>
						<td>{{Auth::user()->password}}</td>
					</tr>
					<tr>
						<td>Email:</td>
						<td>{{Auth::user()->email}}</td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>
