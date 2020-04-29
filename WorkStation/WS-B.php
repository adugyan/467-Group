<!--Name: Hong Wu
    Section: CSCI467
    Semester: Spring 2020
    Due: April 27, 2020
-->

<html>
  <head>
    <title>
      Workstation Program
    </title>
  </head>

  <body bgcolor="#ffffff">
  <p><h1>Print Shipping Labels</h1></p>

<! link to Shipping Rate Chart>
    <a href="https://1ivu6q1gqh2kndjc23ryof11v5-wpengine.netdna-ssl.com/wp-content/uploads/2019/01/Shipping-Rates-Cheapest-Carrier-Ground-Full.png" target="_blank">
      <font color="#000000" size="5">
        Rate Chart
      <font>
    </a>
  <br>

<! Link to Shipping methods>

<! link to UPS>
    <a href="https://www.ups.com/ship/single-page?tx=2698278392944037&loc=en_US&src=uis&promoCodeAlias=eaSy&WT.mc_id=ds_gclid:EAIaIQobChMI5dSwk_iM6QIVyrzACh1hKQ6pEAAYASAAEgLKB_D_BwE:dscid:71700000031307137:searchterm:%2Bups%20%2Bshipping%20%2Blabel&WT.srch=1" target="_blank">
      <font color="#000000" size="5">
        UPS
      <font>
    </a>
  <br>

<! link to USPS>
    <a href="https://cns.usps.com/labelInformation.shtml" target="_blank">
      <font color="#000000" size="5">
        USPS
      <font>
    </a>
  <br>

<! link to DHL>
    <a href="https://mydhl.express.dhl/us/en/shipment.html#/?fromAddressLine=399%20Gilbert%20Dr%20%23325&fromCountry=US&shipmentFromDashboard=true#address-details" target="_blank">
      <font color="#000000" size="5">
        DHL
      <font>
    </a>
  <br>

<! link to FedEx>
    <a href="https://mydhl.express.dhl/us/en/shipment.html#/?fromAddressLine=399%20Gilbert%20Dr%20%23325&fromCountry=US&shipmentFromDashboard=true#address-details" target="_blank">
      <font color="#000000" size="5">
        FedEx
      <font>
    </a>
  <br>

<?php
  include('secret.php');
  error_reporting(0);

  try{  //attempt to connect to database
    $dsn = "mysql:host=courses;dbname=z1751913";
    $pdo = new PDO($dsn, $username, $password);
  }
  catch(PDOexception $e){  //in case connection fail
    echo "Connection to database failed: ".$e->getMessage();
  }



//the sql command for the table
  $sql = "SELECT Distinct OrderID, Orders.number, OrderAmount, CusName, CusMail, CusEmail, WeightBrackets, ShipCharge
          FROM   Orders, Product
          WHERE  Orders.number = Product.number
          AND    ShipStatus = 'Authorized Order'
          ORDER  BY ProductLoc;";

//save the result of the comand in $result and fetch each row in $rows
  $result = $pdo->query($sql);
  $rows = $result->fetchAll(PDO::FETCH_ASSOC);
//table and form begin
  echo "<table border=1 cellspacing=5 cellpadding=3 bgcolor=\"#000000\">";
  echo "<form action=\"http://students.cs.niu.edu/~z1751913/Invoice.php\" target=\"_blank\" 
         method=\"post\" onSubmit=\"setTimeout(function(){location.reload()}, 2000)\">"; //refresh page in 2 seconds
  echo "<tr><td><input type=\"submit\"/></td></tr>";

//print out the column title
  echo "<tr>";
  echo "<td><font color=\"#ffffff\" size=\"5\">Mark Shipped</font></td>";
  echo "<td><font color=\"#ffffff\" size=\"5\">Order ID</font></td>";
  echo "<td><font color=\"#ffffff\" size=\"5\">Product ID</font></td>";
  echo "<td><font color=\"#ffffff\" size=\"5\">Amount</font></td>";
  echo "<td><font color=\"#ffffff\" size=\"5\">Name</font></td>";
  echo "<td><font color=\"#ffffff\" size=\"5\">Address</font></td>";
  echo "<td><font color=\"#ffffff\" size=\"5\">E-mail</font></td>";
  echo "<td><font color=\"#ffffff\" size=\"5\">Weight</font></td>";
  echo "<td><font color=\"#ffffff\" size=\"5\">Handling Charge</font></td>";
  echo "</tr>";

//print out the content we select from the tables
  foreach ($rows as $row){
    //print each order
    echo "<tr>";
    $OrderID = $row["OrderID"];

    echo "<td><input type=\"radio\" name=\"ShippedID\" value=$OrderID /></td>";

    foreach ($row as $x){
      echo "<td>";
      echo "<font color=\"#ffffff\" size=\"4\">";
      echo $x;
      echo "</font>";
      echo "</td>";
    }
    echo "</tr>";
  }

//table end
  echo "</form>";
  echo "</table>";
?>

<! link to Packing List>
    <a href="http://students.cs.niu.edu/~z1751913/WS-A.php">
      <font color="#000000" size="5">
        Print Packing List
      <font>
    </a>

  <br>

    <Print Name and Section>
     <p align="center" >
        <font color="#29f23a" size="5">Name:Hong Wu <br/></font>
        <font color="#29f23a" size="5">Section:CSCI 466 - 03</font>
     </p>

  </body>
</html>
