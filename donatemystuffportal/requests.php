<?php 

session_start(); 
if(isset($_SESSION['userid']))
{
?>
<!DOCTYPE HTML>
<html>

<head>
  <title>Donate My Stuff Portal::.Requests.::</title>
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
          <h1><a href="home.php">Donate-My-Stuff Management Portal</a></h1>
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
          <li class="current"><a href="#">Requests</a></li>
          <li><a href="offers.php">Offers</a></li>
          <li><a href="donors.php">Donors</a></li>
          <li><a href="beneficiaries.php">Beneficiaries</a></li>
          <li><a href="#">Contact Us</a></li>
		  <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>
    <div id="site_content">
<?php 
#status change has been requested
if($_GET['action']=='status' ) {   

#get posted data and other necessary details for changing the status
$requestid=$_POST['requestid'];
$changed_status =$_POST['newvalue'];
$manid = $_SESSION['userid'];
$url="http://za-donate-my-stuff.appspot.com/changerequeststatus";

// JSONify - the data to send to the API
				$postData = array(
				'id' => $requestid,
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
				
				die();

}
#flag change has been requested
if($_GET['action']=='flag' && $_POST['requestid']!="" && $_POST['newvalue'] !="") {   

#get posted data and other necessary details for changing the flag
$requestid=$_POST['requestid'];
$changed_flag =$_POST['newvalue'];
$manid = $_SESSION['userid'];
$url="http://za-donate-my-stuff.appspot.com/changerequestflag";

// JSONify - the data to send to the API
				$postData = array(
				'id' => $requestid,
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
				
				die();
}
#render the default page (showing all the requests)
	
	else { ?>
      <div class="content">
        <h1>Requests</h1>
        <div class="content_item">
		<table id="requests">
		<thead>
        <tr>
            <th>BeneficiaryID</th>
            <th>ItemName</th>
            <th>Gender</th>
			<th>Size</th>
			<th>Age</th>
			<th>Status</th>
			<th>Flag</th>
        </tr>
    </thead>
    <tbody>
		<?php
		$json = file_get_contents('http://za-donate-my-stuff.appspot.com/donationrequests?beneficiary='.$_SESSION['userid']); 
		$data = json_decode($json);	
		//parse the json of requests
		//We will show the following tags (BeneficiaryID, Name, GenderCode, Size, Age, and Age Restrictions)
	
		foreach($data->requests as $requests) {
		 echo  '<tr>';
		 echo  '<td>';
		 echo '<a href="?id='.$requests->beneficiaryid.'" class="popup" style="color: black"; title="click to view beneficiary details"><b>'.$requests->beneficiaryid.'</b></a>' ;
		 echo  '</td>';
		 echo  '<td>';
		 echo  $requests->item->name . PHP_EOL ;
		 echo  '</td>';
		 echo  '<td>';
		 echo  $requests->item->gendercode . PHP_EOL ;
		 echo  '</td>';
		 echo  '<td>';
		 echo  $requests->item->size . PHP_EOL ;
		 echo  '</td>';
		 echo  '<td>';
		 echo  $requests->item->age . PHP_EOL ;
		 echo  '</td>';
		 #id of the offer
		$offerid= $requests->id;
         echo '<td  id='.$offerid.' class="statusedit">';
         $statusid=$requests->status;
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
		$flagid=$requests->flag;
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
		 echo  '</td>';
		 echo  '</tr>';
		}

		?>
	 </tbody>
</table>
        </div>
<?php } ?>
      </div>
<div id="mypop" style="display:none">
	
	<?php
	//GET Method implementation, viewing information for a single donor
				//$donid=mysql_escape_string($_GET['id']);
				
				$donid='44b5006a-ddcf-458f-8655-3011b22559df';

				$json = file_get_contents('http://za-donate-my-stuff.appspot.com/donors?donorid='.$donid.'&managerid='.$_SESSION['userid']);
				$data = json_decode($json);
                
				//parse the json of requests
                //We will show the following tags (BeneficiaryID, Name, GenderCode, Size, Age, and Age Restrictions)
                //var_dump($data);
                
                foreach($data->donors as $donor) { ?>
             
		 
                 <div class="content" id="donor_details">
                         <h1>Information about the beneficiary: <?php echo $donor->name. PHP_EOL.' '.$donor->surname. PHP_EOL; ?></h1>
                         <div class="content_item">
                          <p> <b><?php echo $donor->name. PHP_EOL.' '.$donor->surname. PHP_EOL; ?></b> is a potential beneficiary [requester] and can be contacted on:
						  <br /> Telephone: <?php echo $donor->telephone. PHP_EOL; ?>
						  <br />Cellphone: <?php echo $donor->mobile. PHP_EOL; ?>
						  <br />Email Address: <?php echo $donor->email. PHP_EOL; ?>			  
						</div>
				</div>
        
            <?php    }
	?>
</div>	  
	 
     </div>
    <footer>
      <p><a href="home.php">Home</a> | <a href="#">Requests</a> | <a href="offers.php">Offers</a> | <a href="donors.php">Donations</a> | <a href="contact.php">Contact Us</a></p>
      <p>Copyright &copy; 2014 Donate-My-Stuff</p>
    </footer>
  </div>
  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
  <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
  <script type="text/javascript" src="js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="js/jquery.jeditable.mini.js"></script>
  <script type="text/javascript" src="js/jquery.bpopup.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {
     $('ul.sf-menu').sooperfish();
     oTable = $('#requests').dataTable({
        "bJQueryUI": true,
		//"bPaginate": false,
        "sPaginationType": "full_numbers",
		"fnDrawCallback" : function() {
         $('.statusedit').editable('requests.php?action=status', { 
		 indicator : '<img src="images/ajax-loader.gif">',
		 data   	: " {'0':'Open','1':'Allocated','2':'Delivered', '3':'Closed', '-1':'Cancelled','selected':'0'}",
		 type   	: 'select',
		 tooltip  	: 'Click to edit status',
		 submit 	: 'Save',
		 style   	: 'inherit',
		 id   		: 'requestid',
		 name 		: 'newvalue',
		 callback : function(value, settings) {
		 window.location.reload();
		}
	 });
	}
    });
	
  $('.flagedit').editable('requests.php?action=flag', { 
     indicator : '<img src="images/ajax-loader.gif">',
	 data   	: " {'0':'Unverified','1':'Valid','2':'Invalid','selected':'0'}",
     type   	: 'select',
	 id   		: 'requestid',
     name 		: 'newvalue',
	 tooltip  	: 'Click to edit flag',
     submit 	: 'Save',
	 callback : function(value, settings) {
     window.location.reload();
    }
 });
 
});
//popup

  // Semicolon (;) to ensure closing of earlier scripting
    // Encapsulation
    // $ is assigned to jQuery
    ;(function($) {

         // DOM Ready
        $(function() {

            // Binding a click event
            // From jQuery v.1.7.0 use .on() instead of .bind()
            $('.popup').on('click', function(e) {
              
                // Prevents the default action to be triggered. 
                e.preventDefault();

                // Triggering bPopup when click event is fired
                $('#mypop').bPopup({
				modalClose: true,
				fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
				followSpeed: 1500, //can be a string ('slow'/'fast') or int
				modalColor: 'greenYellow'
				
				});

            });

        });

    })(jQuery);
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

