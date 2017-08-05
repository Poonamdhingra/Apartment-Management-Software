<?php
// Common Code Starts
session_start();

if( ! isset($_SESSION["user_id"])) {
	header('Location: index.html');
    exit;
}

$userid = $_SESSION["user_id"];
$firstname = $_SESSION["first_name"];
$lastname = $_SESSION["last_name"];
$email = $_SESSION["email"];



include("dbconnect.php");

// Common Code End
?>






<!DOCTYPE HTML>
<html><head>
        <title>River Plaza</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="keywords" content="Pooled Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design">
        <script type="application/x-javascript">
            addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }
        </script>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <!-- Custom CSS -->
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/morris.css" type="text/css">
        <!-- Graph CSS -->
        <link href="css/font-awesome.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="js/jquery-2.1.4.min.js"></script>
        <!-- //jQuery -->
        <!-- tables -->
        <link rel="stylesheet" type="text/css" href="css/table-style.css">
        <link rel="stylesheet" type="text/css" href="css/basictable.css">
        <script type="text/javascript" src="js/jquery.basictable.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
              $('#table').basictable();
        
              $('#table-breakpoint').basictable({
                breakpoint: 768
              });
        
              $('#table-swap-axis').basictable({
                swapAxis: true
              });
        
              $('#table-force-off').basictable({
                forceResponsive: false
              });
        
              $('#table-no-resize').basictable({
                noResize: true
              });
        
              $('#table-two-axis').basictable();
        
              $('#table-max-height').basictable({
                tableWrapper: true
              });
            });
        </script>
        <!-- //tables -->
        <link href="//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400" rel="stylesheet" type="text/css">
        <link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <!-- lined-icons -->
        <link rel="stylesheet" href="css/icon-font.min.css" type="text/css">
        <!-- //lined-icons -->
    </head><body>
        <div class="page-container">
            <!--/content-inner-->
            <div class="left-content">
                <div class="mother-grid-inner">
                    <!--header start here-->
                    <div class="header-main">
                    
						

						<div class="row">
								<div class="col-md-8 mb5">
								<img src="images/logo.png" height="80" width="500" alt="" >
								</div>
								<!-- div class="col-md-4 mb5" -->
									<div class="profile_details w3l">
                            <ul>
                                <li class="dropdown profile_details_drop">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										
												
												<div class="user-name">
													<p><?php echo $firstname; ?>  (logged in)</p>
													<span>Resident</span>
												</div>
												<i class="fa fa-angle-down"></i>
												<i class="fa fa-angle-up"></i>
												<div class="clearfix"></div>	
											
										</a>
                                    <ul class="dropdown-menu drp-mnu">
                                        <li>
                                            <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
								<!-- /div -->
							</div>

							
							
							
							
					
                        <div class="clearfix"></div>
                    </div>
                    <!--heder end here-->
                    <ol class="breadcrumb text-info">
                        <li class="breadcrumb-item">
                            <a href="index.html">Home</a>
                            <i class="fa fa-angle-right"></i>Dashboard</li>
                    </ol>

					
					
	<div class="four-grids">
					<div class="col-md-3 four-grid">
					    <a href="RES_payments_View.php">
						<div class="four-agileits">
							<div class="icon">
								<i class="glyphicon glyphicon-usd" aria-hidden="true"></i>
							</div>
							<div class="four-text">
								<!--h3>Payment</h3-->
						<?php

						include("dbconnect.php");
						$sql = "Select Amount, Status from transactions where UserId = '$userid'";
                        $result = $pdo->query($sql);
//						$row = $result->fetch();
                                            $amount = 0;
                                            foreach($result as $row){
                                                if ($row['Status'] == "Pending")
                                                        {
                                                    $amount = $amount + $row["Amount"];

                                                            }
                                               
                                           }
                                           if($amount != 0){
                                               echo '<h3>Payment Pending</h3>';
						echo 	'<h4>' . $amount . '</h4>';
                                           } else
                                                    {
                                                        echo 	'<h3>All Payments Done</h3>';
                                                        echo 	'<h4>0</h4>';
                                                    }
                                            
                                            
?>
								<!--h4> 24,420  </h4-->
								
							</div>
							
						</div>
						</a>
					</div>
					<div class="col-md-3 four-grid">
					 <a href="User_Request.html.php">
						<div class="four-agileinfo">
							<div class="icon">
								<i class="glyphicon glyphicon-wrench" aria-hidden="true"></i>
							</div>
							<div class="four-text">
							<h3>Maintenance</h3>
						<?php

						include("dbconnect.php");
						$sql = "Select Status from requests where UserId = '$userid'";
                        $result = $pdo->query($sql);
						$count = $result ->rowCount();
						$row = $result->fetch();
  
                        if ($row['Status'] != "Completed")
					    	{
    					echo '<h4>' . $count . '</h4>';
	}
	else
	{
    					echo '<h4>0</h4>';

	}
?>
							</div>
							
						</div>
						</a>
					</div>
					
					<div class="col-md-3 four-grid">
					 <a href="calendar.php">
						<div class="four-w3ls">
							<div class="icon">
								<i class="glyphicon glyphicon-calendar" aria-hidden="true"></i>
							</div>
							<div class="four-text">
								<h3>Events</h3>
						<?php

						include("dbconnect.php");
						
						$sql = "select * from events where Date between sysdate()
                                 and DATE_ADD(SYSDATE(), INTERVAL 4 DAY)";
                        $result = $pdo->query($sql);
						$row = $result->fetch();
                        $count = $result ->rowCount();
                        if ($count > 0)
					    	{
    					
    					echo '<h4>' . $count . '</h4>';
	}
	else
	{
    					echo '<h4>0</h4>';						                    
    }
?>
								
							</div>
							
						</div>
						</a>
						
						
					</div>
					
					<div class="col-md-3 four-grid">
					 <a href="inbox.php">
						<div class="four-wthree">
							<div class="icon">
								<i class="glyphicon glyphicon-envelope" aria-hidden="true"></i>
							</div>
							<div class="four-text">
								<h3>Mails</h3>
								<?php

						include("dbconnect.php");
						$sql = "Select ReadStatus from mails where ReadStatus = 'New' and UserIdReceiver = '$userid'";
                        $result = $pdo->query($sql);
						$row = $result->fetch();
						$count = $result ->rowCount();

					   if ($count > 0)
						{
						echo '<h3>' . $count . '</h3>';
						
	}
	else
	{
						echo 	'<h3>0</h3>';
						
	}
?>
								
								
							</div>
							
						</div>
						</a>
					</div>
	
					<div class="clearfix"></div>
	</div>
					
			                    <ol class="breadcrumb text-info">
                        <li class="breadcrumb-item">
                            <a href="index.html"></a>
                            </i></li>
                    </ol>		
					
					
					
					</div>					
					
			</div>		
	
	
	
	
	
	
	
	
	
	

                    <!-- script-for sticky-nav -->
		<script>
		$(document).ready(function() {
			 var navoffeset=$(".header-main").offset().top;
			 $(window).scroll(function(){
				var scrollpos=$(window).scrollTop(); 
				if(scrollpos >=navoffeset){
					$(".header-main").addClass("fixed");
				}else{
					$(".header-main").removeClass("fixed");
				}
			 });
			 
		});
		</script>
                    <!-- /script-for sticky-nav -->

                    <!--inner block start here-->
                    <div class="inner-block"></div>
					
					</div>
            </div>
			</div>
			
            <!--//content-inner-->
            <!--/phpbar-menu-->
            <div class="sidebar-menu">
                <header class="logo1">
                    <a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a>
                </header>
                <div style="border-top:1px ridge rgba(255, 255, 255, 0.15)"></div>
                <div class="menu">
                    <ul id="menu">
                        <li>
                            <a href="<?php if($_SESSION["Privilege"]=='Resident') {echo 'Resident_Dashboard1.html.php';} else {echo 'Admin_Dash.php';}?>"><i class="fa fa-tachometer"></i> <span>Dashboard</span><div class="clearfix"></div></a>
                        </li>
                        <li id="menu-academico">
                            <a href="inbox.php"><i class="fa fa-envelope nav_icon"></i><span>Mails</span><div class="clearfix"></div></a>
                        </li>
                        <li>
                            <a href="<?php if($_SESSION["Privilege"]=='Resident') {echo 'RES_payments_View.php';} else {echo 'Admin_Payment.php';}?>"><i class="fa fa-dollar"></i>  <span>Payments</span><div class="clearfix"></div></a>
                        </li>
                        <li>
                            <a href="<?php if($_SESSION["Privilege"]=='Resident') {echo 'User_Request.html.php';} else {echo 'Admin_Request.html.php';}?>"><i class="fa fa-folder-open"></i>  <span>Requests</span><div class="clearfix"></div></a>
                        </li>
                        <li id="menu-academico">
                            <a href="calendar.php"><i class="fa fa-calendar-o"></i>  <span>Events</span> <div class="clearfix"></div></a>
                        </li>
                        <li>
                            <a href="<?php if($_SESSION["Privilege"]=='Resident') {echo 'RES_View_PersonalDetails.php';} else {echo 'Management.php';}?>"><i class="fa fa-check-square-o nav_icon"></i><span><?php if($_SESSION["Privilege"]=='Resident') {echo 'Personal Info';} else {echo 'Management';}?></span><div class="clearfix"></div></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
							<script>
							var toggle = true;
										
							$(".sidebar-icon").click(function() {                
							  if (toggle)
							  {
								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
								$("#menu span").css({"position":"absolute"});
							  }
							  else
							  {
								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
								setTimeout(function() {
								  $("#menu span").css({"position":"relative"});
								}, 400);
							  }
											
											toggle = !toggle;
										});
							</script>
        <!--js -->
        <script src="js/jquery.nicescroll.js"></script>
        <script src="js/scripts.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- /Bootstrap Core JavaScript -->
    


</body></html>

