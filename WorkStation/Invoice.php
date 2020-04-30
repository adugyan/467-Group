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
  <p><h1>Invoice</h1></p>


<?php
  include('connectionVarsFunctions.php');

$pdo = safeConnectC();

  echo "Date:".date("m/d/Y")."<br>";

//fetch customer information by Order ID
  $ShippedID = $_POST["ShippedID"];
  $sql = "UPDATE Orders SET ShipStatus='Shipped' WHERE OrderID=$ShippedID";
  $Result = $pdo->exec($sql);

  $sql = "SELECT OrderID, CusName, CusMail, CusEmail
          FROM Orders WHERE OrderID=$ShippedID;";
  $result = $pdo->query($sql);
  $row = $result->fetch(PDO::FETCH_ASSOC);

//table begin
  echo "<table border=1 cellspacing=5 cellpadding=3 bgcolor=\"#ffffff\">";
//print out the column title
  echo "<tr>";
  echo "<td><font color=\"#000000\" size=\"5\">Order ID</font></td>";
  echo "<td><font color=\"#000000\" size=\"5\">Customer Name</font></td>";
  echo "<td><font color=\"#000000\" size=\"5\">Customer Address</font></td>";
  echo "<td><font color=\"#000000\" size=\"5\">Customer Email</font></td>";
  echo "</tr>";

//print out the content we select from the tables
  echo "<tr>";
  foreach ($row as $x){
    echo "<td>";
    echo "<font color=\"#000000\" size=\"4\">";
    echo $x;
    echo "</font>";
    echo "</td>";
  }
  echo "</tr>";

//table end
  echo "</table>";

  $Email = "";
  $subject = "Order Shipped";
  $txt = "Your Order was shipped.";
  $headers = "From: Parts Company"."\r\n";
  mail($Email,$subject,$txt,$headers);

//fetch order information
  $sql = "SELECT number,OrderAmount,ShipCharge
          FROM Orders WHERE OrderID=$ShippedID;";
  $result = $pdo->query($sql);
  $row = $result->fetch(PDO::FETCH_ASSOC);

  $ProductID = $row["number"];
  $OrderAmount = $row["OrderAmount"];
  $ShipCharge = $row["ShipCharge"];

//connect to parts DB
  try{  //attempt to connect to database
    $dsn = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
    $pdo = new PDO($dsn, "student", "student");
  }
  catch(PDOexception $e){  //in case connection fail
    echo "Connection to database failed: ".$e->getMessage();
  }

//fetch item description etc.
  $sql = "SELECT description, price, pictureURL
          FROM parts WHERE number=$ProductID";
  $result = $pdo->query($sql);
  $row = $result->fetch(PDO::FETCH_ASSOC);

  $description = $row["description"];
  $price = $row["price"];
  $pictureURL = $row["pictureURL"];

//calculate total price
  $itemPrice = $price * $OrderAmount;
  $totalPrice = $itemPrice + $ShipCharge;

//table begin
  echo "<table border=1 cellspacing=5 cellpadding=3 bgcolor=\"#ffffff\">";

//print out the column title
  echo "<tr>";
  echo "<td><font color=\"#000000\" size=\"5\">Product Picture</font></td>";
  echo "<td><font color=\"#000000\" size=\"5\">Description</font></td>";
  echo "<td><font color=\"#000000\" size=\"5\">Order Amount</font></td>";
  echo "<td><font color=\"#000000\" size=\"5\">Price</font></td>";
  echo "<td><font color=\"#000000\" size=\"5\">Total Price</font></td>";
  echo "</tr>";

//print out the content we select from the tables
  echo "<tr>";
  echo "<td><img src=$pictureURL width=_default height=_default/></td>";
  echo "<td><font color=\"#000000\" size=\"4\">$description</font></td>";
  echo "<td><font color=\"#000000\" size=\"4\">$OrderAmount</font></td>";
  echo "<td><font color=\"#000000\" size=\"4\">$price</font></td>";
  echo "<td><font color=\"#000000\" size=\"4\">$itemPrice</font></td>";
  echo "</tr>";


//Total Price
  echo "<tr>";
  echo "<td><font color=\"#000000\" size=\"5\">Total</font></td>";
  echo "<td></td>";
  echo "<td></td>";
  echo "<td></td>";
  echo "<td><font color=\"#000000\" size=\"5\">$totalPrice</font></td>";
  echo "</tr>";

//table end
  echo "</table>";
?>

  <br>
  <br>

    <!Print Name and Section>
     <p align="center" >
        <font color="#29f23a" size="5">Name:Hong Wu<br/></font>
        <font color="#29f23a" size="5">Section:CSCI 467</font>
     </p>

  </body>
</html>
