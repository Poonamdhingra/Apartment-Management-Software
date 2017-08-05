<?php
    opcache_reset();
    session_start();
    include('dbconnect.php');
try
    {
	
	$selectAll = "SELECT transactions.TransactionID, transactions.Date, transactions.Memo, transactions.Amount, transactions.Status, residents.ApartmentNo FROM transactions,residents
WHERE transactions.UserId = residents.UserId AND transactions.Status != 'Completed'
AND residents.ApartmentNo IN (
SELECT apartments.ApartmentNo FROM residents , apartments
WHERE
residents.ApartmentNo = apartments.ApartmentNo )
 ";
        
		$selectAllResult = $pdo->query($selectAll);
		
		}
    catch(PDOException $e)
    {
        die("Something happened:" . $e->getMessage());
    }
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
<link href="css/tablesort.css" rel="stylesheet"> 
<!-- jQuery -->
<script src="js/jquery-2.1.4.min.js"></script>
<!-- //jQuery -->
<!-- tables -->
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
<script>
    $(document).ready(function() {
		$(".status-selector").hide();
		
        var idSelector = '';
        $(".staus-update").click(function(){
            idSelector = $(this).find('input:hidden').val();
            $("#all-p-"+idSelector).hide();
            $("#all-"+idSelector).show();
        });
        $(".status-selector").change(function(){
            var val = $('#all-'+idSelector).val();
            $.ajax({type: "POST",
                url: "Admin_Payment_Ajax.php",
                data: "type=updateStatus&id="+idSelector+'&status='+val,
                success: function(message){
                    document.location.reload(); 
                }
            });
        });
        $(".delete-update").click(function(){
            idSelector = $(this).find('input:hidden').val();
            $.ajax({type: "POST",
                url: "Admin_Payment_Ajax.php",
                data: "type=delete&id="+idSelector,
                success: function(message){
                    document.location.reload(); 
                }
            });
        });
        $(".btn btn-primary").click(function(){
            $.ajax({type: "POST",
                url: "Admin_Payment_Ajax.php",
                data: "type=create&id="+idSelector,
                success: function(message){
                    document.location.reload(); 
                }
            });
        });
    });
	
	
</script>

<!-- //tables -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<!-- lined-icons -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
<!-- //lined-icons -->
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
                                            <span><?php echo $_SESSION['Privilege']; ?> </span>
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
<!--heder end here-->
<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Payments</li>
            </ol>

			<div class="agile-grids">	
				<!-- tables - Residents with Payment Status Pending-->
				<form action="?" method="post">
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Payments Received</h2>
					    <table id="sorttable" class ="tablesorter">
						<thead>
						  <tr>
						    <th>Apt No</th>
							<th>Transaction ID</th>
							<th>Date</th>
							<th>Amount</th>
							<th>Status</th>
							<th>Action</th>
							
						  </tr>
						</thead>
						<tbody>
						<?php
                                        foreach($selectAllResult as $row)
                                        {?>
                                            <tr class="table-row">
                                               <td class="march">
                                                   <?php echo $row['ApartmentNo']; ?>
                                               </td>
                                                <td class="march">
                                                    <?php echo $row['TransactionID'] ?>
                                                </td>
												<td class="march">
                                                    <?php echo $row['Date'] ?>
                                                </td>
                                                <td class="march">
                                                    <?php echo $row['Amount'] ?>
                                                </td>
											
                                                <td class="march">
                                                    <p id="all-p-<?php echo $row['TransactionID']; ?>"><?php echo $row['Status'] ?></p>
                                                    <select  id="all-<?php echo $row['TransactionID']; ?>" class="status-selector" >
                                                        <option value="">Select</option>
                                                        <option value="In Progress">In Progress</option>
                                                        <option value="Completed">Completed</option>
                                                        <option value="Rejected">Rejected</option>
                                                    </select>
                                                </td>
                                                <td class="march">
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                    Options
                                                                    <div class="clearfix"></div>	
                                                            </a>
                                                            <ul class="dropdown-menu drp-mnu">
                                                                <li> <a class="staus-update" href="#"><i class="fa fa-edit"></i> Change Status<input type="hidden" value="<?php echo $row['TransactionID']; ?>"></a> </li> 
                                                                
                                                            </ul>
                                                        </div>
        
                                                </td>
                                            </tr>
                                    <?php }?>
						  
						  
						  
						</tbody>
					  </table>
					</div>
				  </div>
				<!-- //tables -->
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

<!--inner block end here-->

          <div class="clearfix"> </div>
		  <form>
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

</body>
</html>