<?php
    
    session_start();
 
if( ! isset($_SESSION["user_id"])) {
              header('Location: index.html');
    exit;
}
 
$userid = $_SESSION["user_id"];
$firstname = $_SESSION["first_name"];
$lastname = $_SESSION["last_name"];
$email = $_SESSION["email"];

// connect to the database
include("mysqli_dbconnect.php");



	 // get the records from the database the second time after he inserted the data
$GLOBALS['result'] = mysqli_query($link,"SELECT * from residents WHERE UserId = '$userid'");
 
 
?>

<html>
<!DOCTYPE HTML>

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
</head> 


<body>
   <div class="page-container">
   <!--/content-inner-->
<div class="left-content">
	   <div class="mother-grid-inner">
               <!--header start here-->
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
                    </div><!--heder end here-->
<!--heder end here-->
<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Forms <i class="fa fa-angle-right"></i> Personal Info</li>
            </ol>
<!--grid-->
 	<div class="validation-system">
 		
 		<div class="validation-form">
 	<!---->
  	    
        <form action ="?" method = "post" >
         	<div class="vali-form">
            <div class="col-md-6 form-group1">
			<?php while($fetch = mysqli_fetch_array($result))

						{?>
						
						
              <label class="control-label">Firstname</label>
              <input type="text" input name="Firstname" input value ="<?php echo $_SESSION["first_name"]?>" required="">
            </div>
            <div class="col-md-6 form-group1 form-last">
              <label class="control-label">Lastname</label>
              <input type="text" input name="Lastname" input value =<?php echo $_SESSION["last_name"] ?> required="">
            </div>
            <div class="clearfix"> </div>
            </div>
            
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Email</label>
              <input type="text" input name="Email" value = <?php echo $_SESSION["email"] ?> required="">
            </div>
             <div class="clearfix"> </div>
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Social Security No.</label>
              <input type="text" input name="SSN" input value =<?php echo $fetch['SSN'] ?> placeholder="SSN" required="">
            </div>
			<div class="clearfix"> </div>
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Apartment No.</label>
              <input type="text" input name="AptNo" input value =<?php echo $fetch['ApartmentNo'] ?> placeholder="Apt No" required="">
            </div>
			<div class="col-md-12 form-group1 group-mail">
              <label class="control-label ">Date of Birth</label>
              <input type="date" input name="Date_of_birth" class="form-control1 ng-invalid ng-invalid-required" ng-model="model.date" input value =<?php echo $fetch['DateOfBirth'] ?> required="">
            </div>
               
             <div class="clearfix"> </div>
             <div class="clearfix"> </div>
              
             <div class="clearfix"> </div>
            <div class="col-md-12 form-group1 ">
              <label class="control-label">Previous Address</label>
              <input type="text" input name="PreviousAddress"  input value =<?php echo $fetch['PreviousAddress'] ?> placeholder="Your Previous Address" required="">
            </div>
             <div class="clearfix"> </div>
            <div class="vali-form">
            <div class="col-md-6 form-group1">
              <label class="control-label">Pets</label>
              <input name ="Pets" input type="text" input value =<?php echo $fetch['NumPets'] ?> placeholder="Pets" required="">
            </div>
            <div class="col-md-6 form-group1 form-last">
              <label class="control-label">Mobile Number</label>
              <input type="text" input name="MobileNo" input value =<?php echo $fetch['MobileNumber'] ?> placeholder="Mobile Number" required="">
            </div>
            <div class="clearfix"> </div>
            </div>
             <div class="vali-form vali-form1">
            <div class="col-md-6 form-group1">
              <label class="control-label">Spouse Firstname</label>
              <input type="text" input name="Spouse_Firstname" input value =<?php echo $fetch['SpouseFirstName'] ?> placeholder="Spouse Name" required="">
            </div>
            <div class="col-md-6 form-group1 form-last">
              <label class="control-label">Spouse Lastname</label>
              <input type="text" input name="Spouse_Lastname" input value =<?php echo $fetch['SpouseLastName'] ?> placeholder="Spouse SSN" required="">
            </div>
            <div class="clearfix"> </div>
            </div>
             <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Spouse SSN</label>
              <input name= "SpouseSSN" input type="text" input value =<?php echo $fetch['SpouseSSN'] ?> placeholder="Number" required="">
			</div>
			<div class="clearfix"> </div>
			  
			<div class="col-md-12 form-group1 group-mail">
              <label class="control-label ">Spouse Date of Birth</label>
              <input type="date" input name="S_Date_of_birth" input value =<?php echo $fetch['SpouseDateOfBirth'] ?> class="form-control1 ng-invalid ng-invalid-required" ng-model="model.date" required="">
            </div>
               
             <div class="clearfix"> </div>
           
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label ">Date of MoveIn</label>
              <input type="date" input name="Date_of_movein" input value =<?php echo $fetch['MoveInDate'] ?> class="form-control1 ng-invalid ng-invalid-required" ng-model="model.date" required="">
            </div>
             <div class="clearfix"> </div>
            
						<?php } ?>
          
            <div class="col-md-12 form-group">
              <input type="Submit" name="update" class="btn btn-primary">
              
            </div>
          <div class="clearfix"> </div>
        </form>
    
 	<!---->
 </div>
<?php
if (isset($_POST['update']))
{
	include 'RES_UPDATE_PersonalDetails.php';
	exit();
}
?>
</div>
 	<!--//grid-->
	


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
								} ,400);
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