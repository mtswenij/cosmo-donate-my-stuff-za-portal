<!DOCTYPE HTML>
<html>

<head>
  <title>Donate My Stuff Portal</title>
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
          <h1><a href="#">Donate-My-Stuff Management Portal<span class="logo_colour"> version 1.0</span></a></h1>
          <h2>"Making a difference with what we have".</h2>
        </div>
        <form method="post" action="#" id="search">
          <input class="search" type="text" name="search_field" value="search....." onclick="javascript: document.forms['search'].search_field.value=''" />
          <input name="search" type="image" style="float: right;border: 0; margin: 20px 0 0 0;" src="images/search.png" alt="search" title="search" />
        </form>
      </div>
      <nav>
        <ul class="sf-menu" id="nav">
          <li class="current"><a href="#">Home</a></li>
          <li><a href="requests.php">Requests</a></li>
          <li><a href="offers.php">Offers</a></li>
          <li><a href="#">Donations</a></li>
          <li><a href="#">Beneficiaries</a>
            <ul>
              <li><a href="#">Center 1</a></li>
              <li><a href="#">Center 2</a>
            </ul>
          </li>
          <li><a href="#">Contact Us</a></li>
        </ul>
      </nav>
    </header>
    <div id="site_content">
      <div id="sidebar_container">
        <div class="sidebar">
          <h3>Recents Donations</h3>
          <div class="sidebar_item">
            <h4>20 School Shoes Donated</h4>
            <h5>December 16, 2013</h5>
            <p>So and so donated 20 shoes...<br /><a href="#">Read more</a></p>
          </div>
          <div class="sidebar_base"></div>
        </div>
        <div class="sidebar">
          <h3>Latest Offers</h3>
          <div class="sidebar_item">
            <ul>
              <li><a href="#">Offer 1</a></li>
              <li><a href="#">Offer  2</a></li>
              <li><a href="#">Offer  3</a></li>
              <li><a href="#">Offer  4</a></li>
            </ul>
          </div>
          <div class="sidebar_base"></div>
        </div>
        <div class="sidebar">
          <h3>Latest Requests</h3>
          <div class="sidebar_item">
            <ul>
              <li><a href="#">Size 10 Black Shoes</a></li>
              <li><a href="#">Grade 11 Mcbeth Book</a></li>
              <li><a href="#">1 Short Black Trousers (Size 26)</a></li>
              <li><a href="#">20 Soccer Boots (Size 3 - 8)</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="content">
        <h1>Shoes</h1>
        <div class="content_item">
        </div>
      </div>
	   <div class="content">
        <h1>Books</h1>
        <div class="content_item">
        </div>
      </div>
	   <div class="content">
        <h1>Blankets</h1>
        <div class="content_item">
        </div>
      </div>
	   <div class="content">
        <h1>Sport</h1>
        <div class="content_item">
		
        </div>
      </div>
     </div>
    <footer>
      <p><a href="#">Home</a> | <a href="requests.php">Requests</a> | <a href="offers.php">Offers</a> | <a href="donations.php">Donations</a> | <a href="contact.php">Contact Us</a></p>
      <p>Copyright &copy; Donate-My-Stuff</p>
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
