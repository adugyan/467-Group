<!--Name: Hong Wu
    Section: CSCI467
    Semester: Spring 2020
    Date: April 27, 2020
-->

<html>
  <head>
    <title>
      Workstation Program
    </title>
  </head>

  <body bgcolor="#ffffff">
  <p><h1>Packing List</h1></p>


<?php
  include('secret.php');

  try{  //attempt to connect to database
    $dsn = "mysql:host=courses;dbname=z1751913";
    $pdo = new PDO($dsn, $username, $password);
  }
  catch(PDOexception $e){  //in case connection fail
    echo "Connection to database failed: ".$e->getMessage();
  }


  echo "Date:".date("m/d/Y")."<br>";
//Update authorized new orders
  $sql = "UPDATE Orders
           SET   ShipStatus = 'New Order';";
  $result = $pdo->exec($sql);
?>

  <br>

<! link to Start Page>
    <a href="http://students.cs.niu.edu/~z1751913/WS-A.php">
      <font color="#000000" size="5">
        Print Packing List
      <font>
    </a>

  <br>

    <!Print Name and Section>
     <p align="center" >
        <font color="#29f23a" size="5">Name:Hong Wu<br/></font>
        <font color="#29f23a" size="5">Section:CSCI 467</font>
     </p>

  </body>
</html>
