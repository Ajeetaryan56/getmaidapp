<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Contact Us</title>

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,800" rel="stylesheet" /> <!-- https://fonts.google.com/specimen/Open+Sans?selection.family=Open+Sans -->
    <link href="css/all.min.css" rel="stylesheet" /> <!-- https://fontawesome.com/ -->
    <link href="css/bootstrap.min.css" rel="stylesheet" /> <!-- https://getbootstrap.com -->
    <link href="css/index.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="img/favicon.ico"/>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3pro.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link href="css/templatemo-new-vision.css" rel="stylesheet" />
	<link href="css/sari-form.css" rel="stylesheet"/>
</head>
<body>
<div>
<title>JavaScript Alert Box by PHP</title>
	<?php

if (isset($_POST['submit'])){
	$fullName = $_POST['full-name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $company = $_POST['company'];
    $interestedIn = $_POST['interested-in'];
    $description = $_POST['description'];


    $curl = curl_init();
        $baseUrl = 'https://www.lachhan.com/Api/contactus';
        //$baseUrl = 'http://localhost/getmaidapp/api/contactus';
        $url = sprintf("%s", $baseUrl);
        curl_setopt($curl, CURLOPT_URL, $url);
         curl_setopt($curl, CURLOPT_POSTFIELDS,
          http_build_query(array('FullName' => $fullName, 'Email' => $email, 'Phone' => $phone,
          'Company' => $company, 'InterestedIn' => $interestedIn, 'Description' => $description)));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
       // echo $result;
       //$result =  var_dump($result);
       $response  = json_decode($result, true);
         $message = $response['message'];
        echo "<script type='text/javascript'>alert('$message');</script>";
        //echo json_decode($result, true);
        curl_close($curl);
        echo curl_getinfo($curl);

  }

function function_alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

?>
</div>
<div id="container">
    <div id="content">
        <div id="about">
        <div class="col-12">
                    <h1 class="tm-section-header tm-section-header-small mb-4">Lachhan Software Pvt Ltd
                        A 360? IT Service Provider</h1>
        </div>
        <div class="w3-bar w3-green">
                <div class="w3-bar-item"><a href="index.html">Home</a></div>
                <div class="w3-bar-item"><a href="work.html">Our Abilities</a></div>
                 <div class="w3-bar-item"><a href="about-us.html">About Us</a></div>
                 <div class="w3-bar-item"><a href="contact-us.php" style="color:Tomato;">Contact Us</a></div>
         </div>
         </div>
   </div>
   <div>
    <form action="contact-us.php" method="post">
        <div class="container">
            <h4>You can contact us by using "Email: ajeet.patel@lachhan.com or Phone: +91-971-801-0344" or sumbit the below details</h4><br/>
            <h3> Contact Lachhan Software </h3>
            <input type="text" name="full-name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="phone" placeholder="+91-9718010344" required>
            <input type="text" name="company" placeholder="Company">
            <select name="interested-in">
               <option value="mobile">Mobile App Development</option>
                <option value="web">Website Development</option>
                <option value="digital">Digital Marketing</option>
                 <option value="other">Others</option>
              </select>
            <textarea name="description" placeholder="Project Description"></textarea>
            <br><br><br>
            <button type="submit" name="submit">Submit</button>
        </div>
    </form>
</div>
</div>
</body>
</html>


