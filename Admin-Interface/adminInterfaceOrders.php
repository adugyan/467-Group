<?php
//Starts session
session_start();
?>

<html>
<head>
	<title> Search Orders </title>

	<style>
	body
		{
		background: rgba(125, 173, 250, 1.0);
		}

	button.backToMenu
		{
		font-size: 1.2vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 1px 10px;
		box-sizing: border-box;
		width: 10vw;
		margin-left: 0.3vw;
		vertical-align: middle;
		}
	
	div.searchType
		{
		font-size: 1.7vw;
		font-family: sans-serif;
		width: 85%;
		text-align: center;
		margin: auto;
		margin-top: 4%;
		}
	
	select.searchType
		{
		font-size: 1.4vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 0px 22px;
		width: 12vw;
		-webkit-appearance: none;
		}

	div.searchParms
		{
		font-size: 1.7vw;
		font-family: sans-serif;
		width: 85%;
		text-align: center;
		margin: auto;
		margin-top: 3%;
		}
	
	input.searchParmsPrice
		{
		font-size: 1.4vw;
		box-sizing: border-box;
		background: rgba(188, 221, 255, 1.0);
		width: 10vw;
		text-align: center;
		-webkit-appearance: none;
		-moz-appearance: textfield;
		margin-left: 0.3vw;
		margin-right: 0.3vw;
		vertical-align: middle;		
		}

	button.searchParmsPrice
		{
		font-size: 1.4vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 1px 10px;
		box-sizing: border-box;
		width: 12vw;
		margin-left: 0.3vw;
		vertical-align: middle;
		}

	select.searchParmsStatus
		{
		font-size: 1.4vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 0px 22px;
		width: 12vw;
		vertical-align: middle;
		-webkit-appearance: none;
		}
	
	button.searchParmsStatus
		{
		font-size: 1.4vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 1px 10px;
		box-sizing: border-box;
		width: 12vw;
		margin-left: 0.3vw;
		vertical-align: middle;
		}
		
	input.searchParmsDate
		{
		font-size: 1.5vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding-left: 1.3vw;
		width: 13vw;
		margin-left: 0.3vw;
		margin-right: 0.3vw;
		vertical-align: middle;
		-webkit-appearance: none;
		}

	button.searchParmsDate
		{
		font-size: 1.4vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 1px 10px;
		box-sizing: border-box;
		width: 12vw;
		vertical-align: middle;
		margin-left: 0.3vw;
		}

	table, th, td
		{
		font-size: 1.3vw;
		font-family: sans-serif;
		text-align: center;
		margin: auto;
		margin-top: 2%;
		border: 7px solid rgba(216, 235, 255, 1.0);
		border-collapse: collapse;
		}

	tr.headers
		{
		background: rgba(141, 217, 255, 1.0);
		font-size: 1.6vw;
		}

	td
		{
		background: rgba(255, 255, 255, 1.0);
		}

	p.noResults
		{
		font-size: 1.7vw;
		font-family: sans-serif;
		text-align: center;
		margin: auto;
		margin-top: 3%;
		}

	div.arrayTable
		{
		font-size: 1.7vw;
		font-family: sans-serif;
		width: 95%;
		text-align: center;
		margin: auto;
		margin-top: 3%;
		margin-bottom: 8%;
		}

	</style>

	<script type="text/javascript">
		window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='number'){e.preventDefault();return false;}}},true);
	</script>

</head>

<body>
<?php
	//Sets database variables for Catalog/Orders
	$usernameC = "z1838064";
	$passwordC = "1999Dec01";
	$hostnameC = "courses";
	$databaseC = "z1838064";
	$dbOrders = "Orders";
	
	$dbPrice = "ShipCharge";
	$dbDate = "Date";
	$dbStatus = "ShipStatus";
	$dbOrderID = "OrderID";
	
	//Post and Session variable setting
	if(isset($_POST['orderSearchType']))
		$_SESSION['orderSearchType'] = $_POST['orderSearchType'];
	elseif(!isset($_SESSION['orderSearchType']))
		$_SESSION['orderSearchType'] = 'false';

	if(isset($_POST['date1']))
		$_SESSION['date1'] = $_POST['date1'];
	if(isset($_POST['date2']))
		$_SESSION['date2'] = $_POST['date2'];	
	
	if(isset($_POST['parmsStatus']))
		$_SESSION['parmsStatus'] = $_POST['parmsStatus'];
	elseif(!isset($_SESSION['parmsStatus']))
		$_SESSION['parmsStatus'] = 'false';
	
	if(isset($_POST['price1']))
		$_SESSION['price1'] = $_POST['price1'];
	if(isset($_POST['price2']))
		$_SESSION['price2'] = $_POST['price2'];		

	//Return to menu button
	echo "
	<form method='GET' action='./adminInterfaceMenu.php'>
		<button class='backToMenu' type='submit'>Back to Menu</button>
	</form>";
	
	//Search through orders
	getOrderSearchType();
	getOrderSearchParameters();
	orderSearch();
	
//==========================================Functions========================================//
	function safeConnectC()
		{
		//Does a fail-conscious connection
		try
			{
			//Creates a connection to the database specified and makes a variable 
			//for the connection object
			$dsn = "mysql:host=" . $GLOBALS['hostnameC'] . ";dbname=" . $GLOBALS['databaseC'];
			$pdo = new PDO($dsn, $GLOBALS['usernameC'], $GLOBALS['passwordC']);
			}
		
		//Catches the exception generated by a failed connection
		catch(PDOexception $e)
			{
			echo "Connection to database failed: " . $e->getMessage();
			}		

		//Returns connection object
		return $pdo;
			
		}	
	
	function getOrderSearchType()
		{
		//Saves order search type as $_POST['orderSearchType']
		echo "
		<div class=searchType>
			<form method='POST'>
			<label>
				Search orders by: 
			</label>
				<select class='searchType' name='orderSearchType' onchange='this.form.submit()'>
					<option disabled selected value=' '> </option>";
					if($_SESSION['orderSearchType'] == 'dateRange')
						echo "<option value='dateRange' selected> Date Range </option>";
					else
						echo "<option value='dateRange'> Date Range </option>";
					
					if($_SESSION['orderSearchType'] == 'status')
						echo "<option value='status' selected> Status </option>";
					else
						echo "<option value='status'> Status </option>";
					
					if($_SESSION['orderSearchType'] == 'priceRange')
						echo "<option value='priceRange' selected> Price Range </option>";
					else
						echo "<option value='priceRange'> Price Range </option>";
			
					echo "
				</select>
			</form>	
		</div>";
		}

	function getOrderSearchParameters()
		{
		//Gets search type		
		echo "
		<div class=searchParms>
		<form method='POST'>	
			<label>";
			
		//Date range parms
		if($_SESSION['orderSearchType'] == 'dateRange')
			{
			echo "
				Enter the date range to search for: 
			</label>";
			
			if(isset($_SESSION['date1']))
					echo "<input class='searchParmsDate' type='date' name='date1' value='" . $_SESSION['date1'] . "'> </input>";
				else
					echo "<input class='searchParmsDate' type='date' name='date1'> </input>";
			if(isset($_SESSION['date2']))
					echo "<input class='searchParmsDate' type='date' name='date2' value='" . $_SESSION['date2'] . "'> </input>";
				else
					echo "<input class='searchParmsDate' type='date' name='date2'> </input>";
			
			//Date submit button
			echo "<button class='searchParmsDate' type='submit'> Submit Range </button>";
								
			}
		
		//Status parms
		elseif($_SESSION['orderSearchType'] == 'status')
			{
			echo "
				Enter the status to search for: 
			</label>
				<select class='searchParmsStatus' name='parmsStatus' onchange='this.form.submit()'>
					<option disabled selected value=' '> </option>";
					if($_SESSION['parmsStatus'] == "Shipped")
						echo "<option value='Shipped' selected> Shipped </option>";
					else
						echo "<option value='Shipped'> Shipped </option>";
			
					if($_SESSION['parmsStatus'] == "Authorized")
						echo "<option value='Authorized' selected> Authorized </option>";
					else
						echo "<option value='Authorized'> Authorized </option>";
				echo "
				</select>";	
			
			}

		//Price range perms
		elseif($_SESSION['orderSearchType'] == 'priceRange')
			{
			echo "
				Enter the price range to search for: 
			</label>";
				
			if(isset($_SESSION['price1']))
					echo "<input class='searchParmsPrice' type='number' placeholder='0.00' step='0.01' min='0' name='price1' value='" . $_SESSION['price1'] . "'> </input>";
				else
					echo "<input class='searchParmsPrice' type='number' placeholder='0.00' step='0.01' min='0' name='price1'> </input>";
			if(isset($_SESSION['price2']))
					echo "<input class='searchParmsPrice' type='number' placeholder='0.01' step='0.01' min='0' name='price2' value='" . $_SESSION['price2'] . "'> </input>";
				else
					echo "<input class='searchParmsPrice' type='number' placeholder='0.01' step='0.01' min='0' name='price2'> </input>";
			
			//Price submit button
			echo "<button class='searchParmsPrice' type='submit'> Submit Range </button>";
			
			}

		//Catchall
		else
			echo "</label>";

		echo "			
			</form>
		</div>";
			
		}	

	function printOrderSearch($array)
		{	
		//Empty array message
		if(empty($array))
			{
			echo "<p class='noResults'> No matching results found. </p>";
			return;
			}
		
		//Print headers
		echo "
		<div class='arrayTable'>
			<table class='arrayTable'>
				<tr class='headers'>
					<th>
					Order ID
					</th>
					<th>
					Weight Bracket
					</th>
					<th>
					Total Price
					</th>
					<th>
					Customer Name
					</th>
					<th>
					Customer Email
					</th>
					<th>
					Customer Address
					</th>
					<th>
					Order Date
					</th>
					<th>
					Shipping Status
					</th>
					<th>
					Part ID
					</th>
					<th>
					Order Quantity
					</th>
				</tr>";
		
		//Print each row
		foreach($array as $var)
			{
			echo "
				<tr>
					<td>" . $var['OrderID'] . "</td>";
				    echo "
					<td>" . $var['WeightBrackets'] . "</td>";
					echo "
					<td>" . $var['ShipCharge'] . "</td>";
				    echo "
					<td>" . $var['CusName'] . "</td>";
				    echo "
					<td>" . $var['CusEmail'] . "</td>";
				    echo "
					<td>" . $var['CusMail'] . "</td>";
				    echo "
					<td>" . $var['Date'] . "</td>";
				    echo "
					<td>" . $var['ShipStatus'] . "</td>";
				    echo "
					<td>" . $var['number'] . "</td>";
				    echo "
					<td>" . $var['OrderAmount'] . "</td>
				</tr>";
			
			}
			echo "
			</table>
		</div>";

		}

	function orderSearch()
		{
		//Date range search
		if(($_SESSION['orderSearchType'] == 'dateRange') and (isset($_SESSION['date1'])) and (isset($_SESSION['date2'])))
			{
			//Unsets other session parms
			unset($_SESSION['parmsStatus']);
			unset($_SESSION['price1']);
			unset($_SESSION['price2']);
			
			//Connects to db
			$pdo = safeConnectC();
			
			//Creates and runs query
			$sql = "SELECT * FROM " . $GLOBALS['dbOrders'] . " WHERE " . $GLOBALS['dbDate'] . " BETWEEN '" . $_SESSION['date1'] . "' AND '" . $_SESSION['date2'] . "' ORDER BY " . $GLOBALS['dbOrderID'] . " ASC;";
			$result = $pdo->query($sql);
			$result = $result->fetchAll();
			
			//Outputs results
			printOrderSearch($result);
			
			}
		
		//Status search
		if(($_SESSION['orderSearchType'] == 'status') and ($_SESSION['parmsStatus'] != 'false'))
			{
			//Unsets other session parms
			unset($_SESSION['date1']);
			unset($_SESSION['date2']);
			unset($_SESSION['price1']);
			unset($_SESSION['price2']);

			//Connects to db
			$pdo = safeConnectC();
			
			//Creates and runs query
			$sql = "SELECT * FROM " . $GLOBALS['dbOrders'] . " WHERE " . $GLOBALS['dbStatus'] . " = '" . $_SESSION['parmsStatus'] . "' ORDER BY " . $GLOBALS['dbOrderID'] . " ASC;";
			$result = $pdo->query($sql);
			$result = $result->fetchAll();
			
			//Outputs results
			printOrderSearch($result);
			
			}

		//Price range search
		if(($_SESSION['orderSearchType'] == 'priceRange') and (isset($_SESSION['price1'])) and (isset($_SESSION['price2'])))
			{
			//Unsets other session parms
			unset($_SESSION['date1']);
			unset($_SESSION['date2']);
			unset($_SESSION['parmsStatus']);

			//Connects to db
			$pdo = safeConnectC();
			
			//Creates and runs query
			$sql = "SELECT * FROM " . $GLOBALS['dbOrders'] . " WHERE " . $GLOBALS['dbPrice'] . " BETWEEN '" . $_SESSION['price1'] . "' AND '" . $_SESSION['price2'] . "' ORDER BY " . $GLOBALS['dbOrderID'] . " ASC;";
			$result = $pdo->query($sql);
			$result = $result->fetchAll();
			
			//Outputs results
			printOrderSearch($result);
					
			}

		}

?>

</body>
</html>
