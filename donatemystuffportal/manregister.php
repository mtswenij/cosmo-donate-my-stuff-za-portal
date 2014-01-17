<!DOCTYPE HTML>
<html>
<head>
  <title>Donate My Stuff Portal-Registration</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
</head>
<body>
  <div id="main">
    <header>
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="login.php">Donate-My-Stuff Management Portal</a></h1>
          <h2>"Making a difference with what we have".</h2>
        </div>
      </div>
	</header>
    <div id="site_content">
		      <div class="content">
        <h1>Please Register</h1>
        <div class="content_item">
		<?php

if (isset($_POST['registration'])) {
  

	$return = "\r";
	$yourname = trim(htmlspecialchars($_POST['your_name']));
	$youresurname = trim(htmlspecialchars($_POST['your_surname']));
	$youremail = trim(htmlspecialchars($_POST['your_email']));
	$yourmobile = trim(htmlspecialchars($_POST['your_mobile']));
	$youragency = trim(htmlspecialchars($_POST['your_agency']));
    $yourtel = trim(htmlspecialchars($_POST['your_tel']));
	$yourpassword = trim(htmlspecialchars($_POST['your_password']));
	
	//these variables are only for security purposes and are not sent over to database
    $user_answer = trim(htmlspecialchars($_POST['user_answer']));
	$answer = trim(htmlspecialchars($_POST['answer']));
	
	
	//perform validation here
        function email_is_valid($email) {
              return preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i',$email);
            }

	if (email_is_valid($youremail) && !eregi("\r",$youremail) && !eregi("\n",$youremail) && $yourpassword != "" && $youragency !="" && $yourname !="" && substr(md5($user_answer),5,10) === $answer) 
	  {
		//JSONify - the data to send to the API
		$postData = array(
		'name' => $yourname,
		'surname' => $yourusrname,
		'email' => $youremail,
		'mobile' => $yourmobile,
		'agency_name' => $youragency,
		'telephone' => $yourtel,
		'address' => array('country' => 'South Africa'),
		'password' => $yourpassword
		);

		//Setup cURL for submission data via POST to donate-my-stuff cloud instance
		$ch = curl_init('http://za-donate-my-stuff.appspot.com/registermanager');
		curl_setopt_array($ch, array(
		CURLOPT_POST => TRUE,
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json'   #this is important for JSON
		),
		CURLOPT_POSTFIELDS => json_encode($postData)
		));

		//Send the request
		$response = curl_exec($ch);

		// Check for errors
		if($response === FALSE){
			die(curl_error($ch));
		}

				// Decode the response
				$responseData = json_decode($response, TRUE);

				if($responseData['status'] == '401')
				{
				 echo "<p style='color: red;'>Registration Failed <a href=manregister.php>Try Again</a> </p>";
				 die();
				}
				elseif ($responseData['status'] == '400')
				{
				echo "<p style='color: green;'>Registration Successful --> <a href=login.php>Click Here</a> to continue</p>";
				die();
				}
				else
				{
				  echo "<p style='color: red;'>Something went wrong --></p> ". $responseData['message'];
				die();
				}
		}
		else
        {  
			 echo '<p style="color: red;">Please ensure that your email address, name, password, agency is valid before registering.</p>';
            
		}

		}

		 //generate number for preventing spams		
		 $number_1 = rand(1, 9);
		 $number_2 = rand(1, 9);
		 $answer = substr(md5($number_1+$number_2),5,10);
?>
        <form id="contact" action="manregister.php" method="post">
            <div class="form_settings">
              <p><span>Name</span><input class="contact" type="text" name="your_name" value="<?php echo $yourname; ?>" /></p>
			  <p><span>Surname</span><input class="contact" type="text" name="your_surname" value="<?php echo $yoursurname; ?>" /></p>
			  <p><span>Email Address</span><input class="contact" type="text" name="your_email" value="<?php echo $youremail; ?>" /></p>
              <p><span>Password</span><input class="contact" type="password"  name="your_password" value="<?php echo $yourpassword; ?>" /></p>
			  <p><span>Mobile</span><input class="contact" type="text" name="your_mobile" value="<?php echo $yourmobile; ?>" /></p>
			  <p><span>Telephone</span><input class="contact" type="text" name="your_tel" value="<?php echo $yourtel; ?>" /></p>
			  <p><span>Agency</span><input class="contact" type="text" name="your_agency" value="<?php echo $youragency; ?>" /></p>
              <p style="line-height: 1.7em;">To help prevent spam and automated regsitrations, please enter the answer to this question:</p>
              <p><span><?php echo $number_1; ?> + <?php echo $number_2; ?> = ?</span><input type="text" name="user_answer" /><input type="hidden" name="answer" value="<?php echo $answer; ?>" /></p>
              <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="registration" value="Register" /></p>
            </div>
        </form>
        </div>
      </div>
     </div>
    <footer>
      <p>Copyright&copy;2014 Donate-My-Stuff</p>
    </footer>
  </div>
  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
  <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('ul.sf-menu').sooperfish();
    });
  </script>
</body>
</html>