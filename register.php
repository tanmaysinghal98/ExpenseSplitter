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
        <h2 class="form-signin-heading">Register</h2>
        <br>
        <input type="text" class="form-control" name="name" placeholder="Name" required="" autofocus="" pattern="[a-zA-Z\s]+" />
        <br>
        <input type="text" class="form-control" name="phone" placeholder="Phone Number" required="" autofocus="" pattern="/(7|8|9)\d{9}/" />
        <br>
        <input type="text" class="form-control" name="username" placeholder="LoginID" required="" autofocus="" />
        <br>
        <input type="password" class="form-control" name="password" placeholder="Password" required=""/>
        <br>
        <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password" required=""/>
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
      </form>
    </div>
<!-- </body>
</html> -->
<?php
require_once('Database.php');
require_once('Credentials.php');

$db = new Db(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

if (isset($_POST['username']))
{
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirmpassword = $_POST['confirmpassword'];
  $phone = $_POST['phone'];
  $name = $_POST['name'];

  if (strcmp($password, $confirmpassword) == 0)
  {
    $query = "Insert into Auth values (?, ?)";
    $result = $db->execSql($query, array($username, $password), $response);
    if ($result == 0)
    {
      echo "<h1>LoginId Already taken!</h1>";
    }
    else
    {
      $query = "Insert into UserInfo (Name, Phone, LoginId) values (?, ?, ?)";
      $result = $db->execSql($query, array($name, $phone, $username), $response);
      header("Location: index.php");
    }
  }
  else
  {
    echo "<h1>Passwords don't match</h1>";
  }
}
 ?>
