<?php

session_start();

?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Donate My Stuff Portal::.Login.::</title>
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
        <h1>Please Login</h1>
        <div class="content_item">
          <?php
            $email = 'enter email address here';
            $password= 'enter password here';
            
            //perform validation here
            function email_is_valid($email) {
              return preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i',$email);
            }

            if (isset($_POST['login_submitted'])) {
              $return = "\r";
              $youremail = trim(htmlspecialchars($_POST['your_email']));
			  $yourpassword = trim(htmlspecialchars($_POST['your_password']));
              $user_answer = trim(htmlspecialchars($_POST['user_answer']));
              $answer = trim(htmlspecialchars($_POST['answer']));
              if (email_is_valid($youremail) && !eregi("\r",$youremail) && !eregi("\n",$youremail) && $yourpassword != ""  && substr(md5($user_answer),5,10) === $answer) 
			  {
         			   
				// JSONify - the data to send to the API
				$postData = array(
				'username' => $youremail,
				'password' => $yourpassword
				);
				
				//JSONify the array
				$data_string = json_encode($postData);
				
							
				//create the conext (mainly used for headers)
				$context =
				array("http"=>
				  array(
					"method" => "POST",
					"header" => "Content-Type: application/json",					
					"content" => $data_string
				  )
				);
				
				//context for passing the headers
				$context = stream_context_create($context);
				
				$response = file_get_contents("http://za-donate-my-stuff.appspot.com/managerlogin", false, $context);

			
				//Decode the response
				$responseData = json_decode($response, TRUE);
      
				if($responseData['status'] == '101')
				{
				 echo "<p style='color: red;'>Login Error: Please Check username/password<a href=login.php> [ Try Again ]</a> </p>";
				 die();
				}
				elseif($responseData['status']== '100')
				{
				//set the session as login is successful
				$_SESSION['userid']=$responseData['message'];
				echo "<p style='color: green;'>Login Successful --> <a href=home.php> [ Click Here ]</a> to continue</p>";
				die();
				}
				else
				{
				echo "<p style='color: red; '>Connection Problems --></p> ". $responseData;
				die();
				}
			}
			else
            {  
			 echo '<p style="color: red;">Please enter  a valid email address, password and the answer to the simple maths question before logging in.</p>';
            
			}
            }
            $number_1 = rand(1, 9);
            $number_2 = rand(1, 9);
            $answer = substr(md5($number_1+$number_2),5,10);
          ?>
          <form id="contact" action="login.php" method="post">
            <div class="form_settings">
              <p><span>Email Address</span><input class="contact" type="text" name="your_email" value="<?php echo $email; ?>" /></p>
              <p><span>Password</span><input class="contact" type="password"  name="your_password" value="<?php echo $password; ?>" /></p>
              <p style="line-height: 1.7em;">To help prevent spam and automated logins, please enter the answer to this question:</p>
              <p><span><?php echo $number_1; ?> + <?php echo $number_2; ?> = ?</span><input type="text" name="user_answer" /><input type="hidden" name="answer" value="<?php echo $answer; ?>" /></p>
              <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="login_submitted" value="Login" /></p>
			  <p style="padding-top: 15px"><span>&nbsp;</span><a href="manregister.php">Do not have a username? - Register</a></p>
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
