<?php
//Starts session
session_start();
?>

<html>
<head>
	<title> Administrative Interface </title>

	<style>
	body
		{
		background: rgba(125, 173, 250, 1.0);
		}

	div.buttons
		{
		position: absolute;
		top: 40%;
		left: 50%;
		transform: translate(-50%, -50%);
		font-size: 2vw;	
		}

	button.orderButton
		{
		font-size: 2vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 1px 10px;
		box-sizing: border-box;
		width: 20vw;
		height: 5vw;
		margin-left: 0.3vw;
		vertical-align: middle;
		transform: translate(-75%, 90%);
		}

	button.bracketButton
		{
		font-size: 2vw;	
		text-align: center;
		background: rgba(188, 221, 255, 1.0);
		padding: 1px 10px;
		box-sizing: border-box;
		width: 20vw;
		height: 5vw;
		margin-left: 0.3vw;
		vertical-align: middle;
		transform: translate(75%, -50%);
		}

	</style>

</head>

<body>
<?php
	echo "
	<div class=buttons>";
	
		//Search Orders button
		echo "
		<form method='GET' action='./adminInterfaceOrders.php'>
			<button class='orderButton' type='submit'>Search Orders</button>
		</form>";
		
		//Set Weight Brackets button
		echo "
		<form method='GET' action='./adminInterfaceBrackets.php'>
			<button class='bracketButton' type='submit'>Set Weight Brackets</button>
		</form>";

	echo "
	</div>";

?>

</body>
</html>
