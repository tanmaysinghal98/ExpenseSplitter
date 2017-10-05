<?php
require_once('Database.php');
require_once('Credentials.php');

$db = new Db(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

session_start();
$name = $_SESSION['Name'];
$userid = $_SESSION['UserId'];

$query = "select UserId, Name from UserInfo";
$db->execSql($query, array(), $response);
$names = $response;
// var_dump($response);


 ?>
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
        <h2 class="form-signin-heading">Create Group</h2>
        <br>
        <input type="text" class="form-control" name="groupname" placeholder="Group Name" required="" autofocus="" />
        <br>
        <?php
            for($i = 0; $i < sizeof($names); $i++)
            {
              echo '<div class="checkbox">';
              echo '<label><input type="checkbox" value="" name="'.$names[$i]['Name'].'">'.$names[$i]['Name'].'</label>';
              echo '</div>';
            }
        ?>
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="creategroup">Create Group</button>
        <br>
        <a href="Logout.php" class="btn btn-lg btn-danger btn-block" role="button">Logout</a>
      </form>
    </div>
<!-- </body>
</html> -->
<?php
if (isset($_POST['creategroup']))
{
  $selected = array();
  $k = 0;
  for($i = 0; $i < sizeof($names); $i++)
  {
    $Name = str_replace(' ', '_', $names[$i]['Name']);
    if(isset($_POST[$Name]))
    {
      $selected[$k] = (int)$names[$i]['UserId'];
      $k++;
    }
  }
  var_dump($selected);

  $query = "Insert into GroupInfo(Name, NumPeople) values (?, ?)";
  $db->execSql($query, array($_POST['groupname'], sizeof($selected)), $response);

  $query = "select GroupID from GroupInfo where Name = ?";
  $db->execSql($query, array($_POST['groupname']), $response);

  $groupid = $response[0]['GroupID'];

  $query = "Insert into GroupMembers values (?, ?)";
  $db->execSql($query, array($groupid, $_POST['groupname']), $response);
  for($i = 0; $i < sizeof($selected); $i++)
  {
    $query = "Insert into GroupMembers values (?, ?)";
    $db->execSql($query, array($groupid, $selected[$i]), $response);
  }

  header("Location: groups.php");
}
 ?>
