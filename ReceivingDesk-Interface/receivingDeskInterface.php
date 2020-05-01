<?php
//Starts session
session_start();
?>

<html>
<head>
	<title> Receiving Desk Interface </title>

	<style>
	body
		{
		background: rgba(125, 173, 250, 1.0);
		}
	
	button.addDelivery
		{
		position: absolute;
		top: 40%;
		left: 50%;
		transform: translate(-50%, -50%);
		font-size: 2vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 4px 20px;
		box-sizing: border-box;
		}

	div.inputPage
		{
		font-size: 1.7vw;
		font-family: sans-serif;
		width: 85%;
		text-align: center;
		margin: auto;
		margin-top: 3%;
		margin-bottom: 8%;
		}
	
	input.deliveryAmount
		{
		font-size: 1.2vw;
		box-sizing: border-box;
		background: rgba(188, 221, 255, 1.0);
		width: 10vw;
		text-align: center;
		-webkit-appearance: none;
		-moz-appearance: textfield;
		margin-left: 0.3vw;
		margin-right: 0.3vw;
		}

	button.setAmount
		{
		font-size: 1.2vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 1px 10px;
		box-sizing: border-box;
		width: 17vw;
		margin-left: 0.3vw;
		}

	table.partInventory
		{
		font-size: 1.5vw;
		font-family: sans-serif;
		text-align: center;
		margin: auto;
		margin-top: 2%;

		}

	select.partID
		{
		font-size: 1.0vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 0px 22px;
		width: 8vw;
		-webkit-appearance: none;
		}

	button.submitID
		{
		font-size: 1.0vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 1px 10px;
		box-sizing: border-box;
		width: 7vw;
		margin-top: 0.3vw;
		margin-bottom: 0.3vw;
		margin-left: 0.3vw;
		margin-right: 0.3vw;
		}
	
	select.partDesc
		{
		font-size: 1.0vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 0px 23px;
		width: 30vw;
		-webkit-appearance: none;
		}

	button.submitDesc
		{
		font-size: 1.0vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 1px 10px;
		box-sizing: border-box;
		width: 15vw;
		margin-top: 0.3vw;
		margin-bottom: 0.3vw;
		margin-left: 0.3vw;
		margin-right: 0.3vw;
		}

	input.deliveryInput
		{
		font-size: 1.0vw;
		box-sizing: border-box;
		background: rgba(188, 221, 255, 1.0);
		width: 17vw;
		text-align: center;
		-webkit-appearance: none;
		-moz-appearance: textfield;
		}

	button.submitDelivery
		{
		font-size: 1.5vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 1px 10px;
		box-sizing: border-box;
		width: 34vw;
		margin-top: 2vw;
		}

	div.afterSubmit
		{
		font-size: 2vw;
		font-family: sans-serif;
		width: 35%;
		text-align: center;
		position: fixed;
		top: 47%;
		left: 50%;
		transform: translate(-50%, -80%)			
		}

	button.addAnotherDelivery
		{
		font-size: 2vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 4px 20px;
		box-sizing: border-box;
		}

	</style>

	<script type="text/javascript">
		window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='number'){e.preventDefault();return false;}}},true);
	</script>

</head>

<body>
<?php
	//Sets database variables for Catalog
	$usernameC = "z1838064";
	$passwordC = "1999Dec01";
	$hostnameC = "courses";
	$databaseC = "z1838064";
	$dbCatalog = "Product";
	
	$dbPartAmount = "ProductAmount";

	//Sets database variables for Legacy Database
	$usernameL = "student";
	$passwordL = "student";
	$hostnameL = "blitz.cs.niu.edu";
	$databaseL = "csci467";
	$dbParts = "parts";
	
	$dbPartID = "number";
	$dbPartDescription = "description";	
	
	//Sets important $_POST variables to SESSION variables instead
	if(isset($_POST['addDelivery']))
		$_SESSION['addDelivery'] = $_POST['addDelivery'];
	if(isset($_POST['deliveryAmount']))
		$_SESSION['deliveryAmount'] = $_POST['deliveryAmount'];
	elseif(!isset($_SESSION['deliveryAmount']))
		$_SESSION['deliveryAmount'] = 0;
			
	//Shows default view for page before delivery is received 
	if(!isset($_SESSION['addDelivery']) or isset($_POST['addAnotherDelivery']))
		{
		echo "
			<form method='POST'> 
				<button class='addDelivery' type='submit' value='true' name='addDelivery'>
					Add Delivery to Inventory
				</button>
			</form>";
			
		if(isset($_SESSION['deliveryAmount']))
			unset($_SESSION['deliveryAmount']);
		}

	//Shows form for adding parts from delivery to inventory
	else
		{		
		//Gets DB connection
		$pdo = safeConnectL();	
		
		//Creates combined array sorted by ID
		$sql = "SELECT " . $dbPartID . ", " . $dbPartDescription . " FROM " . $dbParts . " ORDER BY " . $dbPartID . " ASC;";
		$result = $pdo->query($sql);
		$combinedArrayID = $result->fetchAll();

		//Creates combined array sorted by Description
		$sql = "SELECT " . $dbPartID . ", " . $dbPartDescription . " FROM " . $dbParts . " ORDER BY " . $dbPartDescription . " ASC;";
		$result = $pdo->query($sql);
		$combinedArrayDesc = $result->fetchAll();

		//Creates array of IDs
		$sql = "SELECT " . $dbPartID . " FROM " . $dbParts . " ORDER BY " . $dbPartID . " ASC;";
		$result = $pdo->query($sql);
		$arrayID = $result->fetchAll();
		$searchArrayID = array_column($arrayID, $dbPartID);
		
		//Creates array of descriptions
		$sql = "SELECT " . $dbPartDescription . " FROM " . $dbParts . " ORDER BY " . $dbPartDescription . " ASC;";
		$result = $pdo->query($sql);
		$arrayDesc = $result->fetchAll();
		$searchArrayDesc = array_column($arrayDesc, $dbPartDescription);
		
		//Lets user set amount of part types in delivery
		if($_SESSION['deliveryAmount'] == 0 and !isset($_POST['submitDelivery2']))
			{
			echo "
				<div class=inputPage>
					<div class='deliveryAmount'>
						<form method='POST'>
							<label for='deliveryAmount'>
								Please select amount of part types in delivery:
							</label>
							<input class='deliveryAmount' type='number' name='deliveryAmount' min='0' value='" . $_SESSION['deliveryAmount'] . "'>
							<button class='setAmount' type='submit'>
								Set Amount
							</button>
						</form>
					</div>
				</div>";
			}
		
		//Shows table of parts, descriptions, and total in inventory 
		elseif($_SESSION['deliveryAmount'] != 0 and !isset($_POST['submitDelivery2'])) 
			{
			echo "<div class=inputPage>";
			
			//Alternate amount button
			echo "
				<div class='deliveryAmount'>
					<form method='POST'>
						<label for='deliveryAmount'>
							Please select amount of part types in delivery:
						</label>
						<input class='deliveryAmount' type='number' name='deliveryAmount' min='0' value='" . $_SESSION['deliveryAmount'] . "'>
						<button class='setAmount' type='submit'>
							Reset and Set Amount
						</button>
					</form>
				</div>";

			//Shows table headers
			echo "
				<table class='partInventory'>
					<tr class='headers'>
						<th>
							Part ID
						</th>
						<th>
							
						</th>
						<th>
							Part Description
						</th>
						<th>
							
						</th>
						<th>
							Parts in Delivery
						</th>
					</tr>";
			
			echo "
				<form method='POST' id='partForm'>";
			
			
			//Creates table rows equal to deliveryAmount
			for($i = 0; $i < $_SESSION['deliveryAmount']; $i++)
				{
				echo "
					<tr class='rows'>";

				//Part ID dropdown search field
				echo "		
					<td>
						<select class='partID' name='partID" . $i . "'>";

				//Adds a default unselectable option
				echo "<option disabled selected value=' '> </option>";			

				//Puts sorted IDs into drop down menu which persists and adapts
				foreach($arrayID as $var) 
					{
					//Unsets _POST partID$i if it is blank
					if(isset($_POST['partID' . $i]))
						{
						if($_POST['partID' . $i] == ' ')
							unset($_POST['partID' . $i]);
						}
										
					//Checks if ID has already been selected
					if(isset($_POST['partID' . $i]) and !isset($_POST['submitDesc' . $i]))
						{	
						if($_POST['partID' . $i] == $var[$dbPartID])						
							echo '<option value=' . '"' . $var[$dbPartID] . '" selected>' . $var[$dbPartID] . '</option>';
						else
							echo '<option value=' . '"' . $var[$dbPartID] . '">' . $var[$dbPartID] . '</option>';
						}
					
					//If description already set, uses matching part ID
					elseif(isset($_POST['partDesc' . $i]))
						{	
						if($combinedArrayID[(array_search($var[$dbPartID], $searchArrayID))][$dbPartDescription] == $_POST['partDesc' . $i])
							{
							echo '<option value=' . '"' . $var[$dbPartID] . '" selected>' . $var[$dbPartID] . '</option>';
							if(isset($_POST['submitID' . $i]))
								unset($_POST['submitID' . $i]);
							}
						else
							echo '<option value=' . '"' . $var[$dbPartID] . '"' . '>' . $var[$dbPartID] . '</option>';
						}
					
					//Shows all other normal values
					else
						echo '<option value=' . '"' . $var[$dbPartID] . '"' . '>' . $var[$dbPartID] . '</option>';						
					}
					
				//Closes tags
				echo "
					</select>
				</td>";
				
				//Save ID button
				echo "
					<td>
						<button class='submitID' type='submit' value='true' name='submitID" . $i . "'>
							Save ID
						</button>
					</td>";

				//Part description dropdown search field
				echo "		
					<td>
						<select class='partDesc' name='partDesc" . $i . "'>";

				//Adds a default unselectable option
				echo "<option disabled selected value=' '> </option>";			

				//Puts sorted descriptions into drop down menu which persists and adapts
				foreach($arrayDesc as $var) 
					{
					//Unsets _POST partDesc$i if it is blank
					if(isset($_POST['partDesc' . $i]))
						{
						if($_POST['partDesc' . $i] == ' ')
							unset($_POST['partDesc' . $i]);
						}
				
					//Checks if description has already been selected
					if(isset($_POST['partDesc' . $i]) and !isset($_POST['submitID' . $i]))
						{
						if($_POST['partDesc' . $i] == $var[$dbPartDescription])
							echo '<option value=' . '"' . $var[$dbPartDescription] . '" selected>' . $var[$dbPartDescription] . '</option>';
						else
							echo '<option value=' . '"' . $var[$dbPartDescription] . '">' . $var[$dbPartDescription] . '</option>';
						}
					
					//If ID already set, uses matching part description
					elseif(isset($_POST['partID' . $i]))
						{	
						if(intval($combinedArrayDesc[(array_search($var[$dbPartDescription], $searchArrayDesc))][$dbPartID] == $_POST['partID' . $i]))
							{
							echo '<option value=' . '"' . $var[$dbPartDescription] . '" selected>' . $var[$dbPartDescription] . '</option>';
							if(isset($_POST['submitDesc' . $i]))
								unset($_POST['submitDesc' . $i]);
							}
						else
							echo '<option value=' . '"' . $var[$dbPartDescription] . '"' . '>' . $var[$dbPartDescription] . '</option>';
						}
					
					//Shows all other normal values
					else
						echo '<option value=' . '"' . $var[$dbPartDescription] . '"' . '>' . $var[$dbPartDescription] . '</option>';							
					}					

				//Closes tags
				echo "
					</select>
				</td>";

				//Save Description button
				echo "
					<td>
						<button class='submitDesc' type='submit' value='true' name='submitDesc" . $i . "'>
							Save Description
						</button>
					</td>";

				//Sets unset deliveryInput variables
				if(!isset($_POST['deliveryInput' . $i]))
					$_POST['deliveryInput' . $i] = 0;
				
				//Parts in Delivery number input
				echo "		
						<td>
							<input type='number' class='deliveryInput' name='deliveryInput" . $i . "' min='0' value='" . $_POST['deliveryInput' . $i] . "'>
						</td>						
					</tr>";
				}
				
			//Ends table
			echo "
				</table>";
			
			//Delivery submit button and confirmation button
			if(isset($_POST['submitDelivery']))
				{
				echo "
					<button class='submitDelivery' type='submit' value='true' name='submitDelivery2'>
						Confirm Addition to Inventory
					</button>";					
				unset($_POST['submitDelivery']);
				}
			else
				{
				echo "		
					<button class='submitDelivery' type='submit' value='true' name='submitDelivery'>
						Add Parts in Delivery to Inventory
					</button>";
				}			
			
			//Closes form	
			echo "	
				</form>
			</div>";
			}
		
		//If delivery submit button hit, adds part amounts to inventory 
		elseif(isset($_POST['submitDelivery2']))
			{
			unset($_POST['submitDelivery2']);
			$pdo = safeConnectC();
			
			//Presets variables in case of empty table
			$submitSuccess = false;
			$failedSubmit = true;
			
			//Adds amounts to inventory based on ID
			for($j = 0; $j < $_SESSION['deliveryAmount']; $j++)
				{
				if(isset($_POST['partID' . $j]))
					{
					//Creates query to add part amount to database
					$sql = "UPDATE " . $dbCatalog . " SET " . $dbPartAmount . " = " . $dbPartAmount . " + " . $_POST['deliveryInput' . $j] . " WHERE " . $dbPartID . " = " . $_POST['partID' . $j] . ";";
				
					if(($pdo -> query($sql)) == true)
						{
						$submitSuccess = true;
						}
					else
						{
						//Sets failure variables
						$failedSubmit = $j;
						$submitSuccess = false;

						//Breaks out of submit loop
						$j = $_SESSION['deliveryAmount'];
						}
					}
				}
			
			echo "
				<div class='afterSubmit'>";
			
			//Outputs success message
			if($submitSuccess == true)
				{
				echo "
					<p class=submitSuccess>
						All item amounts have been successfully added to the inventory.
					</p>";
				unset($submitSuccess);
				}
			
			//Outputs empty table error message
			elseif($failedSubmit == true)
				{
				echo "
					<p class=submitSuccess>
						No items entered to add to inventory.
					</p>";
				unset($submitSuccess);
				}
			
			//Outputs submission error message
			else
				{
				
				echo "
					<p class=submitError>
						There was an error adding the amount for item ID: " . $_POST['partID' . $failedSubmit] . " to the inventory. It and all data afterwards was not added to inventory. If the problem persists, please contact support.
					</p>";
				unset($submitSuccess);
				}				
			
			//Button to add another delivery
			echo "
				<form method='POST'> 
					<button class='addAnotherDelivery' type='submit' value='true' name='addAnotherDelivery'>
						Return to First Page
					</button>
				</form>
			</div>";
			
			}
		}

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
		
	function safeConnectL()
		{
		//Does a fail-conscious connection
		try
			{
			//Creates a connection to the database specified and makes a variable 
			//for the connection object
			$dsn = "mysql:host=" . $GLOBALS['hostnameL'] . ";dbname=" . $GLOBALS['databaseL'];
			$pdo = new PDO($dsn, $GLOBALS['usernameL'], $GLOBALS['passwordL']);
			}
		
		//Catches the exception generated by a failed connection
		catch(PDOexception $e)
			{
			echo "Connection to database failed: " . $e->getMessage();
			}		

		//Returns connection object
		return $pdo;
			
		}	
		

?>

</body>
</html>
