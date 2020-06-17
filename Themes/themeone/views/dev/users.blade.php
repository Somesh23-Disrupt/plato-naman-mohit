<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Subscribed Users</title>
		<link rel="shortcut icon" type="image/x-icon" href="{{themes('dev/devicon.png')}}">
		<link rel="stylesheet" href="{{themes('dev/style.css')}}">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.jqueryui.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.21/js/dataTables.jqueryui.min.js"></script>

		<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
#myInput {

  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
  }

</style>
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
			<h2>Subscribed Users</h2>
			<div>
			    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Email</th>
                <th>Subscribed Date</th>
            </tr>
        </thead>
        <tbody>
		<?php $count=0;
		foreach($users as $user){
 		 $count++; ?>

            <tr>
				<td>{{$count}}</td>
				<td>{{$user->email}}</td>
				<td>{{$user->created_at}}</td>
            </tr>
		<?php } ?>
        </tbody>

	</table>

<script>$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
			</div>
		</div>
	</body>
</html>
