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
	margin-top: 10px;
  margin-bottom: 80px;
}

.profile {
  margin-top: 40px;
}

.prfilebox {
  max-width: 380px;
  background-color: #fff;
  padding: 15px 35px 45px;
  margin: 0 auto;
  border: 1px solid rgba(0,0,0,0.1);
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
  <div class='profile'>
    <div class='prfilebox'>
        <h2>Hi, <?php session_start();echo $_SESSION['Name'];?></h2>
    </div>
  </div>
    <div class="wrapper">
      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Add New Transaction</h2>
        <br>
        <input type="text" class="form-control" name="amount" placeholder="Amount" required="" autofocus="" />
        <br>
        <input type="text" class="form-control" name="description" placeholder="Description" required="" autofocus="" />
        <br>
        <input type="text" class="form-control" name="date" placeholder="Date" required="" autofocus="" />
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name='addtransaction'>Add Transaction</button>
        <br>
        <a href="Logout.php" class="btn btn-lg btn-danger btn-block" role="button">Logout</a>

      </form>
    </div>
<!-- </body>
</html> -->
<?php
require_once('Database.php');
require_once('Credentials.php');

session_start();
// var_dump((int)$_SESSION['UserId']);

$db = new Db(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

if (isset($_POST['addtransaction']))
{
  $query = "Insert into Transaction values (? ,?, ?, ?, ?)";
  $db->execSql($query, array((int)$_SESSION['UserId'], (int)$_SESSION['GroupId'], (int)$_POST['amount'], $_POST['date'], $_POST['description']), $response);
  header("Location: transaction.php");
}
 ?>
