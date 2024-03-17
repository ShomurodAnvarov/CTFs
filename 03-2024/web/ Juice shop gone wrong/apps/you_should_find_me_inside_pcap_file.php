<?php

$validate=false;
$result;

if(isset($_SERVER['REQUEST_METHOD'])  &&  strcasecmp("post", $_SERVER['REQUEST_METHOD'] ) == 0)
{
   
   if(!isset($_POST['email']) && !isset($_POST['password']) )
   {
       die("Invalid User ID and Password !");
   }
  
       
   $email = $_POST['email'];
   $password = $_POST['password'];
       
   $host = "localhost";
   $db ="appdb";
   $user ="appuser";
   $pass="appsecret123";
   $charset = 'utf8';
   
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false
    ];
    
    $pdo = null;
    
    try
    {
       $pdo = new PDO($dsn, $user, $pass, $opt); 
       $stmt = $pdo->prepare('SELECT * FROM users where email=? and password=?');
       $stmt->execute([$email, $password]);
       $result = $stmt->fetch();
       
       if($result)
       {
           $validate=true; 
       }
     
       
    }
    catch(PDOException $e)
    {
       echo $e->getMessage();
    }
       

}

header('Content-Type: text/html; charset=UTF-8');

?>



<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
<title>Login</title>
</head>
<body>
 
<div class="container mt-1">

<?php 

if($validate === false )
{

?>    

<h3>Login Here<br>
</h3>
 
<form action="you_should_find_me_inside_pcap_file.php" method="POST" class="w-50">
  <div class="form-group">
    <label>Email address</label>
    <input type="email" class="form-control" name="email" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control" name="password" placeholder="Password">
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form> 
 
 
<?php
}
else
{    
?>

 <p class="display-4 text-center">
 
 <?php 
 echo "Welcome " . $result['firstname'] . " " . $result['lastname'] ; 
 if ($result['firstname'] == "Diyorbek" or $result['email'] == "diyorbek1998@exat.uz")
 {
    echo " | here is your flag: <b>nuu_flag{n3tw0rk_f0rens1cs_m4ster}</b>";
 }
 else
 {
    echo "are you sure you are logged in with right credentials?";
 }
 ?>
 <iframe width="1273" height="716" src="https://www.youtube.com/embed/XqZsoesa55w" title="Baby Shark Dance | #babyshark Most Viewed Video | Animal Songs | PINKFONG Songs for Children" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
 </p>

<?php
}
?>
   
</div>

   
</body>
</html>
