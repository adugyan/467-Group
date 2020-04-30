<!DOCTYPE html>
<html>
	<head>
		<title>Order</title>
		<style type="text/css">
			body {
				font-family: Arial, Verdana, sans-serif;
				font-size: 90%;
				color: #666666;
				background-color: #f8f8f8;}
			li {
				list-style-image: url("images/icon-plus.png");
				line-height: 1.6em;}
			table {
				border-spacing: 0px;}
			th, td {
				padding: 5px 30px 5px 10px;
				border-spacing: 0px;
				font-size: 90%;
				margin: 0px;}
			th, td {
				text-align: left;
				background-color: #e0e9f0;
				border-top: 1px solid #f1f8fe;
				border-bottom: 1px solid #cbd2d8;
				border-right: 1px solid #cbd2d8;}
			tr.head th {
				color: #fff;
				background-color: #90b4d6;
				border-bottom: 2px solid #547ca0;
				border-right: 1px solid #749abe;
				border-top: 1px solid #90b4d6;
				text-align: center;
				text-shadow: -1px -1px 1px #666666;
				letter-spacing: 0.15em;}
			td {
				text-shadow: 1px 1px 1px #ffffff;}
			tr.even td, tr.even th {
				background-color: #e8eff5;}
			tr.head th:first-child {
				-webkit-border-top-left-radius: 5px;
				-moz-border-radius-topleft: 5px;
				border-top-left-radius: 5px;}
			tr.head th:last-child {
				-webkit-border-top-right-radius: 5px;
				-moz-border-radius-topright: 5px;
				border-top-right-radius: 5px;}
			fieldset {
				width: 310px;
				margin-top: 20px;
				border: 1px solid #d6d6d6;
				background-color: #ffffff;
				line-height: 1.6em;}
			legend {
				font-style: italic;
				color: #666666;}
			input[type="text"] {
				width: 120px;
				border: 1px solid #d6d6d6;
				padding: 2px;
				outline: none;}
			input[type="text"]:focus,
			input[type="text"]:hover {
				background-color: #d0e2f0;
				border: 1px solid #999999;}
			input[type="submit"] {
				border: 1px solid #006633;
				background-color: #009966;
				color: #ffffff;
				border-radius: 5px;
				padding: 5px;
				margin-top: 10px;}
			input[type="submit"]:hover {
				border: 1px solid #006633;
				background-color: #00cc33;
				color: #ffffff;
				cursor: pointer;}
			.title {
				float: left;
				width: 160px;
				clear: left;}
			.submit {
				width: 310px;
				text-align: right;}
		</style>
	</head>

	<body>
		 <?php include("connectionVarsFunctions.php"); ?>
		<h1>Confirm and place order</h1>


		<table>
			<tr class="head">
				<th></th>
				<th>Number</th>
				<th>Price</th>
				<th>Weight</th>
			</tr>
			<tr>
				<th></th>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="even">
				<th></th>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<th></th>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="even">
				<th></th>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		<form action="" method="get">
			<fieldset>
				<legend>Checkout</legend>
				<p><label class="title" for="name">Name:</label>
					 <input type="text" name="name" id="name"><br />
					 <label class="title" for="email">Email:</label>
					 <input type="text" name="email" id="email"></p>

					 <label class="title" for="card">Card Number:</label>
	 				 <input type="text" name="card" id="card"><br />
	 				 <label class="title" for="cvv">CVV:</label>
	 	 				<input type="text" name="cvv" id="cvv"><br />

           <p><label class="title" for="line 1">Address:</label>
 					 <input type="text" name="line1" id="line1"><br />
					 <label class="title" for="city">City:</label>
  					 <input type="text" name="city" id="city"><br />
					 <label class="title" for="zip">Zip/Postal:</label>
					 <input type="text" name="zip" id="zip">
				   <label for="location" class="title">State:</label>
					 <select name="location" id="location">
						 <option value="il">IL</option>
						 <option value="in">IN</option>
						 <option value="wi">WI</option>
					 </select></p>
				<span class="title">Are you a member?</span>
				<label><input type="radio" name="member" value="yes" /> Yes</label>
				<label><input type="radio" name="member" value="no" /> No</label>
			</fieldset>
 	    <div class="submit"><input type="submit" value="Order Now"/></div>
		</form>

		<?php
		$url = 'http://blitz.cs.niu.edu/CreditCard/';
$data = array(
	'vendor' => 'VE001-99',
	'trans' => '907-987654321-296',
	'cc' => '6011 1234 4321 1234',
	'name' => 'John Doe',
	'exp' => '12/2020',
	'amount' => '654.32');

$options = array(
    'http' => array(
        'header' => array('Content-type: application/json', 'Accept: application/json'),
        'method' => 'POST',
        'content'=> json_encode($data)
    )
);

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
echo($result);
?>


		</body>
</html>
