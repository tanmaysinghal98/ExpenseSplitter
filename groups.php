<?php
require_once('Database.php');
require_once('Credentials.php');

$db = new Db(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

session_start();
$name = $_SESSION['Name'];
$userid = $_SESSION['UserId'];

$query = "select Name, GroupInfo.GroupID from GroupInfo join GroupMembers on GroupMembers.GroupId = GroupInfo.GroupId where GroupMembers.UserId = ?";
$db->execSql($query, array($userid), $response);
$groups = $response;
// var_dump($response);


 ?>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <style>

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
        <h2 class="form-signin-heading">Your Groups</h2>
        <br>
        <div class="list-group">
          <?php
              for($i = 0; $i < sizeof($groups); $i++)
              {
                echo '<button type="submit" class="btn btn-secondary" name="'.$groups[$i]['Name'].'" style="margin-top: 5px; margin-bottom: 5px;">'.$groups[$i]['Name'].'</button>';
              }
          ?>
          <br>
          <a href="creategroup.php" class="btn btn-lg btn-primary btn-block" role="button">Create New Group</a>
          <br>
          <a href="Logout.php" class="btn btn-lg btn-danger btn-block" role="button">Logout</a>
        </div>
      </form>
    </div>
<!-- </body>
</html> -->
<?php
// var_dump(isset($_POST['SDL_Project']));
for($i = 0; $i < sizeof($groups); $i++)
{
  $GroupName = str_replace(' ', '_', $groups[$i]['Name']);
  if(isset($_POST[$GroupName]))
  {
    $_SESSION['GroupName'] = $groups[$i]['Name'];
    $_SESSION['GroupId'] = $groups[$i]['GroupID'];
    header("Location: transaction.php");
  }
}
 ?>
