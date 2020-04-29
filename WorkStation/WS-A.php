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
           SET   ShipStatus = 'Authorized Order'
           WHERE ShipStatus = 'New Order';";

//save the result of the comand in $result and fetch each row in $rows
  $result = $pdo->query($sql);

//the sql command for the table, sum up order amount and sort by location
//                               in convenient to picking items
  $sql = "SELECT ProductNum, ProductLoc, SUM(OrderAmount)
            FROM Orders,Product
           WHERE Product.number=Orders.number
             AND ShipStatus = 'Authorized Order'
           GROUP BY ProductLoc
           ORDER BY ProductLoc;";

//save the result of the comand in $result and fetch each row in $rows
  $result = $pdo->query($sql);
  $rows = $result->fetchAll(PDO::FETCH_ASSOC);

//table begin
  echo "<table border=1 cellspacing=5 cellpadding=3 bgcolor=\"#ffffff\">";
//print out the column title
  echo "<tr>";
  echo "<td><font color=\"#000000\" size=\"5\">Product ID</font></td>";
  echo "<td><font color=\"#000000\" size=\"5\">Product Location</font></td>";
  echo "<td><font color=\"#000000\" size=\"5\">Order Amount</font></td>";
  echo "</tr>";

//print out the content we select from the tables
  foreach ($rows as $row){
    echo "<tr>";
    foreach ($row as $x){
      echo "<td>";
      echo "<font color=\"#000000\" size=\"4\">";
      echo $x;
      echo "</font>";
      echo "</td>";
    }
    echo "</tr>";
  }


//table end
  echo "</table>";
?>

  <br>

<! link to Start Page>
    <a href="http://students.cs.niu.edu/~z1751913/WS-B.php">
      <font color="#000000" size="5">
        Print Orders
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
