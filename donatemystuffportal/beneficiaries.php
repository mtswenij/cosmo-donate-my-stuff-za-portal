<?php

session_start();
#check if managerid session is set
if(isset($_SESSION['userid']))
{
?>
<!DOCTYPE HTML>
<html>

<head>
<title>Donate My Stuff Portal:.List of Beneficiaries.:</title>
<meta name="description" content="website description" />
<meta name="keywords" content="website keywords, website keywords" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables_themeroller.css" />
<!-- modernizr enables HTML5 elements and feature detects -->
<script type="text/javascript" src="js/modernizr-1.5.min.js"></script>

</head>

<body>
<div id="main">
<header>
<div id="logo">
<div id="logo_text">
<!-- class="logo_colour", allows you to change the colour of the text -->
<h1><a href="index.html">Donate-My-Stuff Management Portal</a></h1>
<h2>"Making a difference with what we have".</h2>
</div>
<form method="post" action="#" id="search">
<input class="search" type="text" name="search_field" value="search....." onclick="javascript: document.forms['search'].search_field.value=''" />
<input name="search" type="image" style="float: right;border: 0; margin: 20px 0 0 0;" src="images/search.png" alt="search" title="search" />
</form>
</div>
<nav>
<ul class="sf-menu" id="nav">
<li><a href="home.php">Home</a></li>
<li><a href="requests.php">Requests</a></li>
<li><a href="offers.php">Offers</a></li>
<li><a href="donors.php">Donors</a></li>
<li class="current"><a href="#">Beneficiaries</a></li>
<li><a href="#">Contact Us</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>
</nav>
</header>
<div id="site_content">
<?php
if($_GET['action']=='beneficent_information') { //GET Method implementation, viewing information for a single user
//$manid=mysql_escape_string($_SESSION['userid']);
$benid=mysql_escape_string($_GET['id']);

$json = file_get_contents('http://za-donate-my-stuff.appspot.com/beneficiaries?beneficiary='.$benid.'&managerid='.$_SESSION['userid']);
                $data = json_decode($json);
                
                //parse the json of requests
                //We will show the following tags (BeneficiaryID, Name, GenderCode, Size, Age, and Age Restrictions)
                            
                foreach($data->beneficiaries as $beficent) { ?>
             
                  <div class="content">
                         <h1>Information about the beneficiary: <?php echo $beficent->name. PHP_EOL.' '.$beficent->surname. PHP_EOL; ?></h1>
                         <div class="content_item">
                          <p> <b><?php echo $beficent->name. PHP_EOL.' '.$beficent->surname. PHP_EOL; ?></b> is our beneficiary and can be contacted on:
							  <br />Telephone: <?php echo $beficent->telephone. PHP_EOL; ?>
							  <br />Cellphone: <?php echo $beficent->mobile. PHP_EOL; ?>
							  <br />Email Address: <?php echo $beficent->email. PHP_EOL; ?>
			  
			  
						</div>
				</div>
        
            <?php    }
?>

<?php }
   
   else { ?>
<div class="contentV2">
<h1>List of Beneficiaries</h1>
<div class="content_item">
                <?php
                $json = file_get_contents('http://za-donate-my-stuff.appspot.com/donationoffers');
                $data = json_decode($json);
                
                //parse the json of requests
                //We will show the following tags (BeneficiaryID, Name, GenderCode, Size, Age, and Age Restrictions)
                //var_dump($data);
                
                foreach($data->offers as $offers) {
                
                 echo '<li><a href="?action=beneficent_information&id='.$offers->donorid . PHP_EOL.'"><b>'.$offers->donorid . PHP_EOL.'</b></a><br /><br /></li>' ;
                
                }

                ?>

</div>
<?php } ?>
</div>
</div>
<footer>
<p><a href="home.php">Home</a> | <a href="requests.php">Requests</a> | <a href="offers.php">Offers</a> | <a href="donors.php">Donors</a> | <a href="contact.php">Contact Us</a></p>
<p>Copyright &copy; 2014Donate-My-Stuff</p>
</footer>
</div>
<!-- javascript at the bottom for fast page loading -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
<script type="text/javascript" src="js/jquery.sooperfish.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$('ul.sf-menu').sooperfish();
oTable = $('#requests').dataTable({
"bJQueryUI": true,
"sPaginationType": "full_numbers"
});
});
</script>
</body>
</html>
<?php

}
else
{
//user session not set.
header("Location: login.php"); 
} 
?>
