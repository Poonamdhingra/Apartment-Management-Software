<?php
    opcache_reset();
    session_start();
	include("dbconnect.php");
    include ('Admin_DashProcess.php');
?>
<!DOCTYPE HTML>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Pooled Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<script src="js/jquery-2.1.4.min.js"></script>
<!-- //jQuery -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<!-- lined-icons -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
<!-- //lined-icons -->
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
</head> 
<body>
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
													<p><?php echo $_SESSION['first_name']; ?>  (logged in)</p>
													<span>Administrator</span>
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
                    </div><!--heder end here-->
<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a> <i class="fa fa-angle-right"></i></li>
            </ol>
<!--four-grids here-->
		<div class="four-grids">
					<div class="col-md-3 four-grid">
						<div class="four-agileits">
							<div class="icon">
								<i class="glyphicon glyphicon-calendar" aria-hidden="true"></i>
							</div>
							<div class="four-text">
							
								
							<?php

						
						$sql = "Select Count(*) AS CNT from events";
                        $result = $pdo->query($sql);
						$row = $result->fetch();

					
						echo 	'<h3>Total Events</h3>';
						echo 	'<h4>' . $row["CNT"] . '</h4>';
	
?>	
								
								
							</div>
							
						</div>
					</div>
					<div class="col-md-3 four-grid">
						<div class="four-agileinfo">
							<div class="icon">
								<i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>
							</div>
							<div class="four-text">
								
							<?php

						
						$sql = "Select SUM(Amount) AS Amount from transactions";
                        $result = $pdo->query($sql);
						$row = $result->fetch();

					
						echo 	'<h3>Total Payment </h3>';
						echo 	'<h4>' . $row["Amount"] . '</h4>';
	
?>		

							</div>
							
						</div>
					</div>
					<div class="col-md-3 four-grid">
						<div class="four-w3ls">
							<div class="icon">
								<i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i>
							</div>
							<div class="four-text">
								<?php

						
						$sql = "Select Count(*) AS CNT from requests";
                        $result = $pdo->query($sql);
						$row = $result->fetch();

					
						echo 	'<h3>Total Requests </h3>';
						echo 	'<h4>' . $row["CNT"] . '</h4>';
	
?>		
								
								
							</div>
							
						</div>
					</div>
					<div class="col-md-3 four-grid">
						<div class="four-wthree">
							<div class="icon">
								<i class="glyphicon glyphicon-envelope" aria-hidden="true"></i>
							</div>
							<div class="four-text">
								<?php

						
						$sql = "Select Count(*) AS CNT from mails";
                        $result = $pdo->query($sql);
						$row = $result->fetch();

					
						echo 	'<h3>Total Mails </h3>';
						echo 	'<h4>' . $row["CNT"] . '</h4>';
	
?>		
								
								
							</div>
							
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
<!--//four-grids here-->
	

				<!-- tables - Residents with Payment Status Pending-->
				
				<div class="tab-pane text-style active" id="panel2">
                            <div class="inbox-right">
                                <div class="mailbox-content">
								<h3>Apartments Not paid the Rent</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                
                                                <th class="head-col">UserID</th>
                                                <th class="head-col">ApartmentNo</th>
                                                <th class="head-col">Lease Amount</th>
												<th class="head-col">Status</th>
                                            </tr>
                                        </thead>
							<tbody>
							<?php
                                        foreach($selectAllResult as $row)
                                        {?>
                                            <tr class="table-row">
                                               <td class="march">
                                                   <?php echo $row['UserId']; ?>
                                               </td>
                                                <td class="march">
                                                    <?php echo $row['ApartmentNo']; ?>
                                                </td>
                                                <td class="march">
                                                    <?php echo $row['LeaseAmount']; ?>
                                                </td>
												<td class="march">
                                                    Not Paid Rent
                                                </td>
												</tr>
												<?php }?>
												
							</tbody>
							
						</table>
					</div>
					</div>
					</div>
					
					<div class="tab-pane text-style active" id="panel2">
                            <div class="inbox-right">
                                <div class="mailbox-content">
								<h3>Pet Friendly Apartments</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                
                                                <th class="head-col">UserID</th>
                                                <th class="head-col">ApartmentNo</th>
                                                <th class="head-col">Number of Pets</th>
												
                                            </tr>
                                        </thead>
							<tbody>
							<?php
                                        foreach($selectPetResult as $row)
                                        {?>
                                            <tr class="table-row">
                                               <td class="march">
                                                   <?php echo $row['UserId']; ?>
                                               </td>
                                                <td class="march">
                                                    <?php echo $row['ApartmentNo']; ?>
                                                </td>
                                                <td class="march">
                                                    <?php echo $row['NumPets']; ?>
                                                </td>
												
												</tr>
												<?php }?>
												
							</tbody>
							
						</table>
					</div>
			</div>
		  
	  </div>
	  
	  <div class="tab-pane text-style active" id="panel3">
                            <div class="inbox-right">
                                <div class="mailbox-content">
								<h3>Apartments with No Pets</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                
                                                <th class="head-col">UserID</th>
                                                <th class="head-col">ApartmentNo</th>
                                                <th class="head-col">Number of Pets</th>
												
                                            </tr>
                                        </thead>
							<tbody>
							<?php
                                        foreach($selectNoPetResult as $row)
                                        {?>
                                            <tr class="table-row">
                                               <td class="march">
                                                   <?php echo $row['UserId']; ?>
                                               </td>
                                                <td class="march">
                                                    <?php echo $row['ApartmentNo']; ?>
                                                </td>
                                                <td class="march">
                                                    <?php echo $row['NumPets']; ?>
                                                </td>
												
												</tr>
												<?php }?>
												
							</tbody>
							
						</table>
					</div>
			</div>
		  
	  </div>
		  
	  </div>
	  <!--//w3-agileits-pane-->	
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
<div class="inner-block">

</div>
<!--inner block end here-->
<!--copy rights start here-->
	
<!--COPY rights end here-->
</div>
</div>
  <!--//content-inner-->
			<!--/sidebar-menu-->
				<div class="sidebar-menu">
					<header class="logo1">
						<a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> 
					</header>
						<div style="border-top:1px ridge rgba(255, 255, 255, 0.15)"></div>
                           <div class="menu">
									<ul id="menu" >
										<li><a href="<?php if($_SESSION["Privilege"]=='Resident') {echo 'Resident_Dashboard1.html.php';} else {echo 'Admin_Dash.php';}?>"><i class="fa fa-tachometer"></i> <span>Dashboard</span><div class="clearfix"></div></a></li>
										
										
										 <li id="menu-academico" ><a href="inbox.php"><i class="fa fa-envelope nav_icon"></i><span>Mails</span><div class="clearfix"></div></a></li>
									
									
									 
									
									  
									 <li><a href="<?php if($_SESSION["Privilege"]=='Resident') {echo 'RES_payments_View.php';} else {echo 'Admin_Payment.php';}?>"><i class="fa fa-dollar"></i>  <span>Payments</span><div class="clearfix"></div></a></li>
									 <li><a href="<?php if($_SESSION["Privilege"]=='Resident') {echo 'User_Request.html.php';} else {echo 'Admin_Request.html.php';}?>"><i class="fa fa-folder-open"></i>  <span>Requests</span><div class="clearfix"></div></a></li>
									
							        <li id="menu-academico" ><a href="calendar.php"><i class="fa fa-calendar-o"></i>  <span>Events</span> <div class="clearfix"></div></a>
									 </li>
                                                                <li><a href="<?php if($_SESSION["Privilege"]=='Resident') {echo 'RES_View_PersonalDetails.php';} else {echo 'Management.php';}?>"><i class="fa fa-check-square-o nav_icon"></i><span><?php if($_SESSION["Privilege"]=='Resident') {echo 'Personal Info';} else {echo 'Management';}?></span><div class="clearfix"></div></a>
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
<!-- morris JavaScript -->	
<script src="js/raphael-min.js"></script>
<script src="js/morris.js"></script>
<script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2014 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2014 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2014 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2014 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2015 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2015 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2015 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2015 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2016 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
				{period: '2016 Q2', iphone: 8442, ipad: 5723, itouch: 1801}
			],
			lineColors:['#ff4a43','#a2d200','#22beef'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
	</script>
</body>
</html>