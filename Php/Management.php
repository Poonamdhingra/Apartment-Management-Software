<?php
/*
@author psindhu@luc.edu

Functionalities : 
1. AJAX Refreshing of pages
2. Edit Status of Apartments
3. Listing apartments based on status
4. Showing the count on each status types of apartments
5. Transaction and Rollback Initialization
6. Javascript Alert and Pop UP
7. Pie chart Implementaion for showing apartment occupancy status
8. Showing details of residents.
*/
    opcache_reset();
    session_start();
    include ('ManagementProcess.php');
    require_once 'dbconnect.php';
?>
<!DOCTYPE HTML>

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Pooled Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-2.1.4.min.js"></script>
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
<link href="css/rp.css" rel='stylesheet' type='text/css' />

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load('visualization', '1', {packages: ['corechart']});
</script>
 
<script>
    $(document).ready(function() {
        var idSelector = '';
        $(".staus-update").click(function(){
            idSelector = $(this).find('input:hidden').val();
            $("#all-p-"+idSelector).hide();
            $("#all-"+idSelector).show();
        });
        $(".status-selector").change(function(){
            var val = $('#all-'+idSelector).val();
            $.ajax({type: "POST",
                url: "ManagementAjax.php",
                data: "type=updateStatus&id="+idSelector+'&status='+val,
                success: function(message){
                    document.location.reload(); 
                }
            });
        });
        $(".delete-update").click(function(){
            idSelector = $(this).find('input:hidden').val();
            $.ajax({type: "POST",
                url: "ManagementAjax.php",
                data: "type=delete&id="+idSelector,
                success: function(message){
                    document.location.reload(); 
                }
            });
        });
        $("#add_apartment").submit(function() {
            var apartment = $('#apartment').val();
            var square = $('#square').val();
            var lease = $('#lease').val();
            var maintenance = $('#maintenance').val();
            $.ajax({type: "POST",
                url: "ManagementAjax.php",
                data: "type=create&apartment="+apartment+"&square="+square+"&lease="+lease+"&maintenance="+maintenance,
                success: function(message){
                    var response = jQuery.parseJSON(message);
                    if(response['status'] == "failed") {
                        alert("Integrity Constraint Violated - The Apartment number already exists");
                    }else {
                        document.location.reload(); 
                    }
                }
            });
        });
        $(".lightbox_trigger").click(function() {
            idSelector = $(this).find('input:hidden').val();
            
            $.ajax({type: "POST",
                url: "ManagementAjax.php",
                data: "type=fetch&id="+idSelector,
                success: function(message){
                    $('#myModal').show();
                    var value = jQuery.parseJSON(message);
                    $(".first-name").text(value['FirstName']);
                    $(".last-name").text(value['LastName']);
                    $(".ssn").text(value['SSN']);
                    $(".move-in").text(value['MoveInDate']);
                    $(".email").text(value['Email']);
                    $("#resident-id").val(value['UserId']);
                    $(".head-apartment").text("Resident Information - #" + idSelector);
                }
            });
        });

        $('.close').click(function() {
            $('#myModal').hide();
        });
        
        $('.begin-transaction').click(function() {
           $(".error-message").show().delay(100000).fadeOut();

            var resident = $(this).find('input:hidden').val();
                $.ajax({type: "POST",
                    url: "ManagementAjax.php",
                    data: "type=transaction&id="+resident,
                    success: function(message){
                        var value = jQuery.parseJSON(message);
                        if(value['status'] == "success") {
                            alert("Request is processed and the resident is removed");  
                            document.location.reload();
                        }
                        else
                        {
                            alert("Request cannot be processed as resident have pending payments\n\
                \n\Tip : You can mark the payments as complete by selecting the Move out eligibity button below ");   
                        }

                        $(".error-message").hide().delay(10000).fadeOut();
                        
                    }
                });
            
        });
        
        $('#cmn-toggle-1').change(function() {
            var resident = $("#resident-id").val();
            if(this.checked){
                 $.ajax({type: "POST",
                url: "ManagementAjax.php",
                data: "type=mark&id="+resident,
                success: function(message){
                }
                    
                });
            }
            
        });

    });
</script>
</head> 

<body>
    <div class="page-container">
        <div class="left-content">
	   <div class="mother-grid-inner">
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
                    <div class="clearfix"></div>
                </div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i> Management</li>
                </ol>
                <div>
                    <div class="col-md-4 compose w3layouts">

                        <nav class="nav-sidebar">
                            <ul class="nav tabs">
                                <li class="active"><a href="#pane1" data-toggle="tab" aria-expanded="true"><i class="glyphicon glyphicon-th-list"></i>All Apartments <span><?php echo $countAll ?></span><div class="clearfix"></div></a></li>
                                <li class=""><a href="#pane2" data-toggle="tab" aria-expanded="false"><i class="glyphicon glyphicon-saved"></i>Leased Apartments <span><?php echo $countLeased ?></span><div class="clearfix"></div></a></li>
                                <li class=""><a href="#pane3" data-toggle="tab" aria-expanded="false"><i class="glyphicon glyphicon-tag"></i>Vacant Apartments <span><?php echo $countVacant ?></span><div class="clearfix"></div></a></li>
                                <li class=""><a href="#pane4" data-toggle="tab" aria-expanded="false"><i class="glyphicon glyphicon-lock"></i>Blocked Apartments <span><?php echo $countBlocked ?></span><div class="clearfix"></div></a></li>                             
                                <li class=""><a href="#pane5" data-toggle="tab" aria-expanded="false"><i class="fa fa-building"></i>Add Apartments to Inventory <div class="clearfix"></div></a></li>
                                <li class=""><a href="#pane6" data-toggle="tab" aria-expanded="false"><i class="glyphicon-record"></i>Statistics <div class="clearfix"></div></a></li>                             
                            </ul>
                        </nav>

                    </div>
                    <!-- tab content -->
                    <div class="col-md-8 tab-content tab-content-in w3">
                        <div class="tab-pane text-style active" id="pane1">
                            <div class="inbox-right">
                                <div class="mailbox-content">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="head-col">Apt#</th>
                                                <th class="head-col">Square Feet</th>
                                                <th class="head-col">Lease Amount</th>
                                                <th class="head-col">Status</th>
                                                <th class="head-col">Action</th>
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
                                                    <?php echo $row['SquareFeet'] ?>
                                                </td>
                                                <td class="march">
                                                    <?php echo $row['LeaseAmount'] ?>
                                                </td>
                                                <td class="march">
                                                    <p id="all-p-<?php echo $row['ApartmentNo']; ?>"><?php echo $row['Status'] ?></p>
                                                    <select  id="all-<?php echo $row['ApartmentNo']; ?>" class="status-selector" >
                                                        <option value="">Select</option>
                                                        <option value="Vacant">Vacant</option>
                                                        <option value="Blocked">Blocked</option>
                                                        <option value="Leased">Leased</option>
                                                    </select>
                                                </td>
                                                <td class="march">
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                    Options
                                                                    <div class="clearfix"></div>	
                                                            </a>
                                                            <ul class="dropdown-menu drp-mnu">
                                                                <li> <a class="staus-update" href="#"><i class="fa fa-edit"></i> Change Status<input type="hidden" value="<?php echo $row['ApartmentNo']; ?>"></a> </li> 
                                                                <li> <a class="delete-update" href="#"><i class="fa fa-remove"></i> Delete Apartment<input type="hidden" value="<?php echo $row['ApartmentNo']; ?>"></a> </li>
                                                            </ul>
                                                        </div>
        
                                                </td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane text-style" id="pane2">
                            <div class="inbox-right">
                                <div class="mailbox-content">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="head-col">Apartment No</th>
                                                <th class="head-col">Lease Amount</th>
                                                <th class="head-col">Lease Amount</th>
                                                <th class="head-col">More Info & Ops</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($selectLeasedResult as $row)
                                        {?>
                                            <tr class="table-row">
                                               <td class="march">
                                                   <?php echo $row['ApartmentNo']; ?>
                                               </td>
                                                <td class="march">
                                                    <?php echo $row['SquareFeet'] ?>
                                                </td>
                                                <td class="march">
                                                    <?php echo $row['LeaseAmount'] ?>
                                                </td>
                                                <td class="march">
                                                    <i class="fa fa-eye"></i>
                                                    <a href="#" class="lightbox_trigger"> Resident
                                                        <input type="hidden" value="<?php echo $row['ApartmentNo']; ?>">
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane text-style" id="pane3">
                            <div class="inbox-right">
                                <div class="mailbox-content">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="head-col">Apartment No</th>
                                                <th class="head-col">Square Feet</th>
                                                <th class="head-col">Lease Amount</th>
                                                <th class="head-col">Maintenance Fee</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($selectVacantResult as $row)
                                        {?>
                                            <tr class="table-row">
                                               <td class="march">
                                                   <?php echo $row['ApartmentNo']; ?>
                                               </td>
                                                <td class="march">
                                                    <?php echo $row['SquareFeet'] ?>
                                                </td>
                                                <td class="march">
                                                    <?php echo $row['LeaseAmount'] ?>
                                                </td>
                                                <td class="march">
                                                    <?php echo $row['MaintenaceFee'] ?>
                                                </td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane text-style" id="pane4">
                            <div class="inbox-right">
                                <div class="mailbox-content">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="head-col">Apartment No</th>
                                                <th class="head-col">Square Feet</th>
                                                <th class="head-col">Lease Amount</th>
                                                <th class="head-col">Maintenance Fee</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($selectBlockedResult as $row)
                                        {?>
                                            <tr class="table-row">
                                               <td class="march">
                                                   <?php echo $row['ApartmentNo']; ?>
                                               </td>
                                                <td class="march">
                                                    <?php echo $row['SquareFeet'] ?>
                                                </td>
                                                <td class="march">
                                                    <?php echo $row['LeaseAmount'] ?>
                                                </td>
                                                <td class="march">
                                                    <?php echo $row['MaintenaceFee'] ?>
                                                </td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane text-style" id="pane5">
                            <div class="inbox-right">
                                <div class="mailbox-content">
                                    <form id="add_apartment">
                                        <div class="vali-form">
                                            <div class="col-md-6 form-group1">
                                                <label class="control-label">Apartment Number</label>
                                                <input id="apartment" type="text" placeholder="Apartment Number" required>
                                            </div>
                                            <div class="col-md-6 form-group1 form-last">
                                                <label class="control-label">Square Feet</label>
                                                <input id="square" type="text" placeholder="Square Feet" required>
                                            </div>
                                            <div class="clearfix"> </div>
                                        </div>
                                        <div class="vali-form">
                                            <div class="col-md-6 form-group1">
                                                <label class="control-label">Lease Amount</label>
                                                <input id="lease" type="text" placeholder="Lease Amount" required>
                                            </div>
                                            <div class="col-md-6 form-group1 form-last">
                                                <label class="control-label">Maintenance Fees</label>
                                                <input id="maintenance" type="text" placeholder="Maintenance Fees" required>
                                            </div>
                                            <div class="clearfix"> </div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-default">Reset</button>
                                        </div>
                                         <div class="clearfix"> </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="tab-pane text-style" id="pane6">
                        
                            
                                    
                                    
                            <div class="inbox-right">
                                <div class="mailbox-content">
                                     <div id="visualization" ></div>   
                                    <script type="text/javascript">
                                        function drawVisualization() {
                                            var data = google.visualization.arrayToDataTable([
                                                ['Square Feet', 'Residents'],
                                                <?php
                                                $query1 = "select count(*) as cnt from residents as r where exists ( select * from apartments as a where a.ApartmentNo = r.ApartmentNo AND a.SquareFeet <1000 )";
                                                $query2 = "select count(*) as cnt from residents as r where exists ( select * from apartments as a where a.ApartmentNo = r.ApartmentNo AND a.SquareFeet >=1000 AND a.SquareFeet <2000 )";
                                                $query3 = "select count(*) as cnt from residents as r where exists ( select * from apartments as a where a.ApartmentNo = r.ApartmentNo AND a.SquareFeet >=2000 )";
                                                
                                                $count1 = $pdo->query($query1);
                                                $count2 = $pdo->query($query2);
                                                $count3 = $pdo->query($query3);
                                                
                                                foreach($count1 as $result){
                                                    $GLOBALS['countFirst'] =  $result['cnt'];
                                                }
                                                echo "['1 BHK (1000 Sq.ft)', {$countFirst}],";


                                                foreach($count2 as $result){
                                                    $GLOBALS['countSecond'] =  $result['cnt'];
                                                }
                                                
                                                echo "['2 BHK (2000 Sq.ft)', {$countSecond}],";
                                                
                                                foreach($count3 as $result){
                                                    $GLOBALS['countThird'] =  $result['cnt'];
                                                }
                                                
                                                echo "['3 BHK (3000 Sq.ft)', {$countThird}],";
                                                
                                                ?>
 
                                            ]);

                                            new google.visualization.PieChart(document.getElementById('visualization')).
                                            draw(data, {title:"Resident Occupancy based on Square Feet of Apartments",  width: 500, height: 300, is3D: true, pieSliceText: 'value'});
                                        }

                                        google.setOnLoadCallback(drawVisualization);
                                    </script>
                                    <p style="float:right;">Powered by Google Charts</p>
                                </div>
    
                                </div>
                            </div>
                        </div>
                        <div id="myModal" class="modal">
                            <div class="modal-content">
      
                                <span class="close">×</span>
                                <div class="clearfix"> </div>
                                <div class="h3-heading"><h3 class="head-apartment">Resident Information</h3></div>
                                <div class="a-right">
                                    <h3 class="fa fa-trash">
                                        <a class="begin-transaction" href="#"> 
                                            <input id="resident-id" type="hidden" value=""/> 
                                            Lease Termination 
                                        </a>
                                    </h3>
                                </div>
                                	
                                <div class="clearfix"> </div>
                                    <div class="error-message">
                                    
                                        <div class="loader"></div>
                                        <div class="div-span-loader">
                                            <span class="span-loader">
                                                Processing the request 
                                            </span>
                                        </div>
                                    
                                    </div>
                                <div class="clearfix"> </div>
                                <br clear="all"/>
                                
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="head-col">Label</th>
                                            <th class="head-col">Information</th>
                                        </tr>
                                        <tr>
                                            <td>First Name</td>
                                            <td><label class="first-name"></label></td>
                                        </tr>
                                        <tr>
                                            <td>Last Name</td>
                                            <td><label class="last-name"></label></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td><label class="email"></label></td>
                                        </tr>
                                        <tr>
                                            <td>SSN</td>
                                            <td><label class="ssn"></label></td>
                                        </tr>
                                        <tr>
                                            <td>Move In Date</td>
                                            <td><label class="move-in"></label></td>
                                        </tr>
                                        <tr>
                                            <td>Move out Eligibility</td>
                                            <td colspan="2">
                                                <div class="switch">
                                                    <input id="cmn-toggle-1" class="cmn-toggle cmn-toggle-round" type="checkbox">
                                                    <label for="cmn-toggle-1"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                            </div>
                        </div>
                    </div>
                </div>
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