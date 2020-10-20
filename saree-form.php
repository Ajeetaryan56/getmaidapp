<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Insert Saree Details</title>

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,800" rel="stylesheet" /> <!-- https://fonts.google.com/specimen/Open+Sans?selection.family=Open+Sans -->
	<link href="css/all.min.css" rel="stylesheet" /> <!-- https://fontawesome.com/ -->
	<link href="css/bootstrap.min.css" rel="stylesheet" /> <!-- https://getbootstrap.com -->
	<link href="css/sari-form.css" rel="stylesheet"/>
</head>
<body>
<div>
<title>JavaScript Alert Box by PHP</title>
	<?php

if (isset($_POST['submit'])){
	$sareeName = $_POST['saree-name'];
	$brandName = $_POST['brand-name'];
	$fabricName = $_POST['fabric-name'];
	$priceRange = $_POST['price-range'];
	$length = $_POST['length'];
	$stock = $_POST['stock'];
	$colors = $_POST['colors'];
   // echo array('SareeName' => $sareeName, 'BrandName' => $brandName, 'FabricName' => $fabricName,
  //        'PriceRange' => $priceRange, 'Length' => $length, 'Stock' => $stock, 'Colors' => $colors)   ;

	$curl = curl_init();
		$baseUrl = 'http://192.168.0.105/getmaidapp/api/saree';
		$url = sprintf("%s", $baseUrl);
		curl_setopt($curl, CURLOPT_URL, $url);
         curl_setopt($curl, CURLOPT_POSTFIELDS,
          http_build_query(array('SareeName' => $sareeName, 'BrandName' => $brandName, 'FabricName' => $fabricName,
          'PriceRange' => $priceRange, 'Length' => $length, 'Stock' => $stock, 'Colors' => $colors)));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
      // $message = var_dump($result);
         $response  = json_decode($result, true);
         $message = $response['message'];
        echo "<script type='text/javascript'>alert('$message');</script>";
        curl_close($curl);
}

function function_alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>
</div>
<div>
	<form action="saree-form.php" method="post">
		<div class="container">
			<h1> Saree Details </h1>
			<input type="text" name="saree-name" placeholder="Saree Name" required>
			<input type="text" name="brand-name" placeholder="Brand Name" required>
			<input type="text" name="fabric-name" placeholder="Fabric" required>
			<input type="text" name="price-range" placeholder="Price Range" required>
			<input type="text" name="length" placeholder="Length" required>
			<input type="text" name="stock" placeholder="Stock" required>
			<input type="text" name="colors" placeholder="Colors" required>
			<textarea name="description" placeholder="Description"></textarea>
			<br><br><br>
			<button type="submit" name="submit">Submit</button>
		</div>
	</form>
</div>
</body>
</html>


