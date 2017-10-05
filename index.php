<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <style>
  @import "bourbon";

body {
	background: #eee !important;
}

.wrapper {
	margin-top: 80px;
  margin-bottom: 80px;
}

.form-signin {
  max-width: 380px;
  padding: 15px 35px 45px;
  margin: 0 auto;
  background-color: #fff;
  border: 1px solid rgba(0,0,0,0.1);

	.form-control {
	  position: relative;
	  font-size: 16px;
	  height: auto;
	  padding: 10px;
		@include box-sizing(border-box);

		&:focus {
		  z-index: 2;
		}
	}
}
  </style>
</head>
<body>
    <div class="wrapper">
      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Login</h2>
        <br>
        <input type="text" class="form-control" name="username" placeholder="LoginID" required="" autofocus="" />
        <br>
        <input type="password" class="form-control" name="password" placeholder="Password" required=""/>
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
        <br>
        <a href="register.php" class="btn btn-lg btn-primary btn-block" role="button">Register</a>
      </form>
    </div>
<!-- </body>
</html> -->
<?php
require_once('Database.php');
require_once('Credentials.php');

$db = new Db(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// var_dump($db);


session_start();

if (isset($_POST['username']))
{
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "select * from Auth where LoginID = ? and Password = ?";
  $result = $db->execSql($query, array($username, $password), $response);
  if(isset($response))
  {
    $query = "select Name, UserId from UserInfo where LoginId = ?";
    $db->execSql($query, array($username), $response);
    $_SESSION['UserId'] = $response[0]['UserId'];
    $_SESSION['Name'] = $response[0]['Name'];
    header("Location: groups.php");
  }
  else
  {
    echo "<h1>Wrong LoginID or Password</h1>";
  }
}
 ?>
