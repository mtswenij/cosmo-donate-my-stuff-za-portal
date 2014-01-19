<?php

session_start();
if(isset($_SESSION['userid']))
{

?>
<!DOCTYPE HTML>
<html>

<head>
<title>Donate My Stuff Portal::.Offers.::</title>
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
<li class="current"><a href="#">Offers</a></li>
<li><a href="donors.php">Donors</a></li>
<li><a href="beneficiaries.php">Beneficiaries</a></li>
<li><a href="#">Contact Us</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>
</nav>
</header>
<div id="site_content">
<?php
if($_GET['action']=='donor_information') { 
				//GET Method implementation, viewing information for a single user
				//$manid=mysql_escape_string($_SESSION['userid']);
				$donid=mysql_escape_string($_GET['id']);

				$json = file_get_contents('http://za-donate-my-stuff.appspot.com/donors?donorid='.$donid.'&managerid='.$_SESSION['userid']);
				$data = json_decode($json);
                
				//parse the json of requests
                //We will show the following tags (BeneficiaryID, Name, GenderCode, Size, Age, and Age Restrictions)
                //var_dump($data);
                
                foreach($data->donors as $donor) { ?>
             
		 
                 <div class="content" id="donor_details">
                         <h1>Information about the donor: <?php echo $donor->name. PHP_EOL.' '.$donor->surname. PHP_EOL; ?></h1>
                         <div class="content_item">
                          <p> <b><?php echo $donor->name. PHP_EOL.' '.$donor->surname. PHP_EOL; ?></b> is a frequent donor and can be contacted on:
						  <br /> Telephone: <?php echo $donor->telephone. PHP_EOL; ?>
						  <br />Cellphone: <?php echo $donor->mobile. PHP_EOL; ?>
						  <br />Email Address: <?php echo $donor->email. PHP_EOL; ?>			  
						</div>
				</div>
        
            <?php    }
?>

<?php }
#status change has been requested
if($_GET['action']=='status' ) {   

#get posted data and other necessary details for changing the status
$offerid=$_POST['offerid'];
$changed_status =$_POST['newvalue'];
$manid = $_SESSION['userid'];
$url="http://za-donate-my-stuff.appspot.com/changeofferstatus";

// JSONify - the data to send to the API
				$postData = array(
				'id' => $offerid,
				'userid' => $manid,
				'status' => $changed_status
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
				
				$response = file_get_contents($url, false, $context);
			
				//Decode the response
				$responseData = json_decode($response, TRUE);

}
#flag change has been requested
if($_GET['action']=='flag' && $_POST['offerid']!="" && $_POST['newvalue'] !="") {   

#get posted data and other necessary details for changing the flag
$offerid=$_POST['offerid'];
$changed_flag =$_POST['newvalue'];
$manid = $_SESSION['userid'];
$url="http://za-donate-my-stuff.appspot.com/changeofferflag";

// JSONify - the data to send to the API
				$postData = array(
				'id' => $offerid,
				'userid' => $manid,
				'flag' => $changed_flag
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
				
				$response = file_get_contents($url, false, $context);
			
				//Decode the response
				$responseData = json_decode($response, TRUE);
}
#render the default page (showing all the offers)
   else { ?>
<div class="contentV2">
<h1>Offers</h1>
<div class="content_item">
                <table id="offers">
                <thead>
<tr>
						<th>DonorID</th>
                        <th>OfferDate</th>
						<th>ItemName</th>
						<th>ItemType</th>
                        <th>ItemQuantity</th>
                        <th>ItemSize</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Status</th>
						<th>Flag</th>
</tr>
</thead>
<tbody>
                <?php
                $json = file_get_contents('http://za-donate-my-stuff.appspot.com/donationoffers');
                $data = json_decode($json);
                
                //parse the json of requests
                //We will show the following tags (BeneficiaryID, Name, GenderCode, Size, Age, and Age Restrictions)
                //var_dump($data);
                
                foreach($data->offers as $offers) {
                 echo '<tr>';
                 echo '<td>';
                 echo '<a href="?action=donor_information&id='.$offers->donorid . PHP_EOL.'" style="color: black"; title="click to view donor details"><b>'.$offers->donorid . PHP_EOL.'</b></a>' ;
                 echo '</td>';
                 echo '<td>';
                 echo $offers->offerdate . PHP_EOL ;
                 echo '</td>';
                 echo '<td>';
                 echo $offers->item->name . PHP_EOL ;
                 echo '</td>';
                 echo '<td>';
                 echo $offers->item->type . PHP_EOL ;
                 echo '</td>';
                 echo '<td>';
                 echo $offers->quantity . PHP_EOL ;
                 echo '</td>';
                 echo '<td>';
                 echo $offers->item->size . PHP_EOL ;
                 echo '</td>';
                 echo '<td>';
                 echo $offers->item->gendercode . PHP_EOL ;
                 echo '</td>';
                 echo '<td>';
                 echo $offers->item->age . PHP_EOL ;
                 echo '</td>';
				 #id of the offer
				 $offerid= $offers->id;
                 echo '<td  id='.$offerid.' class="statusedit">';
           		$statusid=$offers->status;
				
				switch ($statusid)
					{
					case "0":
					  echo '<span style="color:red";>'.'Open'.'</span>'. PHP_EOL;
					  break;
					case "1":
					   echo '<span style="color:green";>'.'Allocated'.'</span>'. PHP_EOL;
					  break;
					case "2":
					   echo '<span style="color:green";>'.'Delivered'.'</span>'. PHP_EOL;
					  break;
					case "3":
					   echo '<span style="color:red";>'.'Closed'.'</span>'. PHP_EOL;
					  break;
					case "-1":
					  echo '<span style="color:red";>'.'Cancelled'.'</span>'. PHP_EOL;
					  break;
					default:
					  echo '<span style="color:red";>'.'Open'.'</span>'. PHP_EOL;
					}
                 echo '</td>';
				 #current flag
				 $flagid=$offers->flag;
				 echo '<td id='.$offerid.' class="flagedit">';
     
				switch ($flagid)
					{
					case "0":
					  echo '<span style="color:red";>'.'Unverified'.'</span>'. PHP_EOL;
					  break;
					case "1":
					   echo '<span style="color:green";>'.'Valid'.'</span>'. PHP_EOL;
					  break;
					case "-1":
					  echo '<span style="color:red";>'.'Invalid'.'</span>'. PHP_EOL;
					  break;
					default:
					  echo '<span style="color:red";>'.'Unverified'.'</span>'. PHP_EOL;
				    }
                 echo '</td>';
                 echo '</tr>';
                }

                ?>
         </tbody>
</table>
</div>
<?php } ?>
</div>
</div>
<footer>
<p><a href="home.php">Home</a> | <a href="requests.php">Requests</a> | <a href="offers.php">Offers</a> | <a href="donors.php">Donors</a> | <a href="contact.php">Contact Us</a></p>
<p>Copyright &copy; 2014 Donate-My-Stuff</p>
</footer>
</div>
<!-- javascript at the bottom for fast page loading -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
<script type="text/javascript" src="js/jquery.sooperfish.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/jquery.jeditable.mini.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$('ul.sf-menu').sooperfish();
oTable = $('#offers').dataTable({
"bJQueryUI": true,
"sPaginationType": "full_numbers"

});

 $('.statusedit').editable('offers.php?action=status', { 
     indicator : '<img src="images/ajax-loader.gif">',
	 data   	: " {'0':'Open','1':'Allocated','2':'Delivered', '3':'Closed', '-1':'Cancelled','selected':'0'}",
     type   	: 'select',
	 tooltip  	: 'Click to edit status',
     submit 	: 'Save',
	 style   	: 'inherit',
	 id   		: 'offerid',
     name 		: 'newvalue',
	 callback : function(value, settings) {
     window.location.reload();
    }
 });
 
 $('.flagedit').editable('offers.php?action=flag', { 
     indicator : '<img src="images/ajax-loader.gif">',
	 data   	: " {'0':'Unverified','1':'Valid','2':'Invalid','selected':'0'}",
     type   	: 'select',
	 id   		: 'offerid',
     name 		: 'newvalue',
	 tooltip  	: 'Click to edit flag',
     submit 	: 'Save',
	 callback : function(value, settings) {
     window.location.reload();
    }
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
