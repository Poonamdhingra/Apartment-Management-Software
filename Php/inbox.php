<?php
    opcache_reset();
    session_start();
    include('InboxFetch.php');

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
<style>
a:hover {
    text-decoration : underline
}

</style>
<script>
    $(document).ready(function() {
        $('.single-mail').hide();
        $('#tab5').load('InboxDeleted.php');
        $('.delete-mail').click(function(){
            var id = $(this).attr("id");
            $.ajax({type: "POST",
                url: "ManageInbox.php",
                data: "type=Delete&id="+id,
                success: function(msg){
                    $("#table-row-"+id).remove();
                    $.ajax({type: "POST",
                        url: "ManageInbox.php",
                        data: "type=count",
                        success: function(message){
                            var count = jQuery.parseJSON(message);
                            $("#unreadCountSpan").text(count);
                            $.ajax({type: "POST",
                                url: "ManageInbox.php",
                                data: "type=countInbox",
                                success: function(message){
                                    var count = jQuery.parseJSON(message);
                                    if(count == 0){
                                        $('#emptyMailSpan').text("Your inbox is empty");
                                    }
                                    $('#tab5').load('InboxDeleted.php');
                                }
                            });
                        }
                    });
                }
            });
        });
        $('mailbox-content').on('click','.subject-click',function(){
            var idSelector = $(this).find('input:hidden').val();
           $.ajax({type: "POST",
                url: "ManageInbox.php",
                data: "type=updateInbox&id="+idSelector,
                success: function(message){
                    $("#tablebody").hide();
                    $('#open-content-'+idSelector).show();
                }
            }); 
        }); 
        $(".subject-click").click(function(){
           var idSelector = $(this).find('input:hidden').val();
           $.ajax({type: "POST",
                url: "ManageInbox.php",
                data: "type=updateInbox&id="+idSelector,
                success: function(message){
                    $("#tablebody").hide();
                    $('#open-content-'+idSelector).show();
                }
            });
        });
        $(".go-back-inbox").click(function(){
            $("#tablebody").show();
            $('.single-mail').hide();

        });
    });
</script>
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
                    </div>
                        
                    
							
                    <div class="clearfix"> </div>	
                </div>
<!--heder end here-->
	<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Inbox</li>
            </ol>
<div class="inbox-mail">
	<div class="col-md-4 compose w3layouts">
		
    <nav class="nav-sidebar">
		<ul class="nav tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab" aria-expanded="true"><i class="fa fa-inbox"></i>Inbox <span id="unreadCountSpan"><?php echo $unreadCount ?></span><div class="clearfix"></div></a></li>
          <li class=""><a href="#tab5" data-toggle="tab" aria-expanded="false"><i class="fa fa-trash-o"></i>Delete</a></li>                              
		</ul>
	</nav>
		
</div>
<!-- tab content -->
<div class="col-md-8 tab-content tab-content-in w3">
    <div class="tab-pane text-style active" id="tab1" style="margin: 1em 0;">
  <div class="inbox-right">
         	
      <div class="mailbox-content">
                <table id="tablebody" class="table">
                    
<tbody >
        <tr><span id="emptyMailSpan" style="text-align: center;color:#999;"><?php if($inboxCount == 0){echo "Your inbox is empty";} ?></span></tr>
        <?php
        foreach($query as $fetchRow)
        {?>
        <tr class="table-row" id="table-row-<?php echo $fetchRow['MailId'] ?>">
            <td class="table-text">
                    <a class="subject-click" href="#" style="                          
                       font-weight: <?php echo $style = ($fetchRow['ReadStatus'] == 'New')? 'bold': 'normal' ?>;
                          color: <?php echo $style = ($fetchRow['ReadStatus'] == 'New')? '#000': '#999' ?>">
                            <?php echo $fetchRow['Email']."(".$fetchRow['Privilege'].")"; ?>
                        <input type="hidden" value="<?php echo $fetchRow['MailId'] ?> "/>
                    </a>
            </td>
            <td class="table-text">
                <a class="subject-click" href="#" style="
                      font-weight: <?php echo $style = ($fetchRow['ReadStatus'] == 'New')? 'bold': 'normal' ?>;
                      color: <?php echo $style = ($fetchRow['ReadStatus'] == 'New')? '#000': '#999' ?>">
                    <?php echo $fetchRow['Subject'] ?>
                    <input type="hidden" value="<?php echo $fetchRow['MailId'] ?> "/>
                </a>
            </td>
            <td class="march">
                <?php echo $fetchRow['Date'] ?>
            </td>
            <td>
                <a class="delete-mail" id="<?php echo $fetchRow['MailId'] ?>" style="
                   font-weight: <?php echo $style = ($fetchRow['ReadStatus'] == 'New')? 'bold':'normal'?>" 
                   href="#">Delete</a>
            </td>
        </tr>

        <?php }?>

    </tbody>

                </table>
<?php
                    foreach($querySingle as $fetchRow)
                {?>
          <div id="open-content-<?php echo $fetchRow['MailId'] ?>" class="single-mail" style="display:none;">
                <table  class="table">
                    <tbody>
                       <tr class="mail-content">
                          <td class="march">
                                  <?php echo $fetchRow['Subject'] ?>
                                  <p><?php echo $fetchRow['Email']."(".$fetchRow['Privilege'].")"; ?></p>
                          </td>
                          <td class="march">
                                <?php echo $fetchRow['Date'] ?>
                            </td>
                      </tr>
                      <tr>
                          <td colspan="2" class="table-text">
                              <p><?php echo $fetchRow['Content'] ?></p>
                          </td>
                      </tr>
                      <tr>
                          <td colspan="2"><a class="go-back-inbox" onclick="window.location.reload(true);" href="">Go Back</a></td>
                      </tr>
                    </tbody>
                </table>
                </div>
                <?php }?>
                
               </div>
            </div>
</div>

  <div class="tab-pane text-style" id="tab5" style="margin: 1em 0;">
  	
</div>
</div>
</div>
<div class="clearfix"> </div>
   </div>
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
                    <div class="inner-block">

                    </div>
                </div>

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
        <script src="js/jquery.nicescroll.js"></script>
        <script src="js/scripts.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>