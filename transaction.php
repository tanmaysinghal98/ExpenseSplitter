<?php
require_once('Database.php');
require_once('Credentials.php');

$db = new Db(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

session_start();

$query = "Select UserInfo.Name, Amount, Date, Description from Transaction join UserInfo on UserInfo.UserId = Transaction.FromUID where Transaction.GroupID = ?";
$db->execSql($query, array($_SESSION['GroupId']), $response);
$data = $response;

$query = "select count(UserID) from GroupMembers where GroupID = ?";
$db->execSql($query, array($_SESSION['GroupId']), $response);
$size = (int)$response[0]['count(UserID)'];

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
   max-width: 780px;
   background-color: #fff;
   padding: 15px 35px 45px;
   margin: 0 auto;
   border: 1px solid rgba(0,0,0,0.1);
 }

 .form-signin {
   max-width: 780px;
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
         <h2 class="form-signin-heading">Your Transactions</h2>
         <br>
         <table class="table table-bordered">
          <thead>
            <tr>
              <th>From</th>
              <th>Description</th>
              <th>Date</th>
              <th>Amount</th>
              <th>Pending Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php
              for ($i=0; $i < sizeof($data); $i++) {
                echo '<tr>';
                echo '<td>'.$data[$i]['Name'].'</td>';
                echo '<td>'.$data[$i]['Description'].'</td>';
                echo '<td>'.$data[$i]['Date'].'</td>';
                echo '<td>'.$data[$i]['Amount'].'</td>';
                echo '<td>'.((int)$data[$i]['Amount'])/$size.'</td>';
                echo '</tr>';
              }
            ?>
          </tbody>
        </table>
        <div class='row'>
        <div class="col-4">
          <button class="btn btn-lg btn-danger btn-block" type="submit" name='deletegroup'>Delete Group</button>
        </div>
        <div class='col-4'>
          <a href="newtransaction.php" class="btn btn-lg btn-primary btn-block" role="button">New Transaction</a>
        </div>
        <div class='col-4'>
          <a href="Logout.php" class="btn btn-lg btn-danger btn-block" role="button">Logout</a>
        </div>
      </div>
       </form>
     </div>
<?php
if(isset($_POST['deletegroup']))
{
  $query = "Delete from GroupInfo where GroupID = ?";
  $db->execSql($query, array($_SESSION['GroupId']), $response);
  header("Location: groups.php");
}

 ?>
