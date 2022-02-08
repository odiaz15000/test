<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Imatr Canada Inc. Add a University of College</title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/imatrcacss.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>
	
	<script src="/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>	

<style>
body {
    padding-top: 50px;
}
.input-block-level2 {
	width: 400px;
	font-size: 15px;
	padding: 2px 2px;
}
input [type=text] {
	font-size: 16px;
	padding: 4px 4px;
	font-weight: normal;
}
hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid #D3D3D3;
    margin: 1em 0;
    padding: 0; 
}

</style>
</head>
<body style="background-color:#eeeeee">
<div class="container-fluid">
<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <a class="navbar-brand"><span><img src="/images/canadianflagvs.png" alt="error">&ensp;DATA CENTER</span></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
					<li class="active">
						<a href="addboardcolun.php">DB Management CRUD</a>
					</li>
					<li>
						<!--<a href="addboardrevcolun.php">DB Management Review</a>-->
						<a href="#">DB Management Review</a>
					</li>
					<li>
                        <a href="/logout.php">LOGOUT&emsp;</a>
                    </li>					
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->		
    </nav>
		<div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">
				<span class="fa-stack fa-1x">
                <i class="fa fa-folder-open fa-stack-3x text-primary"></i></span>
				Add to Database&emsp;<small>Create University or College Record</small>	
                </h2>
			</div>
		</div>
		<!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="/voda/mdashboard.php">Admin Dashboard</a>
                    </li>
                    <li><a href="/voda/addboardcolun.php">DB Management CRUD</a></li><li class="active">Create University - College Record</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
<?php
session_start();
require_once '../dbcon.php';

//sanitize input function
function cleanmysql($db, $input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = str_replace('"',"",$input);
	$input = str_replace("'","",$input);
	$input = mysqli_real_escape_string($db, $input);
	$input = htmlentities($input);
	return($input);
}

		if(isset($_POST['submit2'])) {
			
			if(isset($_POST['bname'])) {
				$bname = cleanmysql($db, $_POST['bname']);
			}
			$caddress = cleanmysql($db, $_POST['caddress']);
			$ccity = cleanmysql($db, $_POST['ccity']);
			$cpcode = cleanmysql($db, $_POST['cpcode']);
			$ctel = cleanmysql($db, $_POST['ctel']);
			$cfax = cleanmysql($db, $_POST['cfax']);
			$url = mysqli_real_escape_string($db, $_POST['url']);
			$ucID = $_SESSION['addID'];
			
			$gtype = $_SESSION['gtype'];
			
			if ($gtype=="Board of Governors") {
				
				$query = "UPDATE univcol SET ucID=?, address=?, city=?, pcode=?, url=?, tel=?, fax=?, ugov=? WHERE ucID='" . $ucID . "'";
				
				if($stmt = mysqli_prepare($db,$query)) {
			
					mysqli_stmt_bind_param($stmt,"isssssss",$ucID,$caddress,$ccity,$cpcode,$url,$ctel,$cfax,$gtype);
					
					if(mysqli_stmt_execute($stmt)) {
					unset($_SESSION['gtype']);
					echo "<div class='row'>
								<div class='col-lg-12'>";
								echo "<br><br><div class='panel'>
											<br><h4>&emsp;Success!&ensp;University - College record created.&ensp;<a href='addboardcolun'>Create Next Record</a></h4><br>
										</div>";
								echo "<br><hr>
									<!-- Footer -->
											<ol class='breadcrumb'>
											<li>Copyright &copy; iMatr Canada Inc. 2018-<?php echo date('Y'); ?> All Rights Reserved</li>
											</ol>
								</div>
							</div>";
						exit;
					}
				}
			}
			if ($gtype=="Student Body") {
				echo " INSIDE 4";
				$query = "UPDATE univcol SET ucID=?, address=?, city=?, pcode=?, url=?, tel=?, fax=?, ugov=?, sgov=? WHERE ucID='" . $ucID . "'";
				
				if($stmt = mysqli_prepare($db,$query)) {
						
					mysqli_stmt_bind_param($stmt,"issssssss",$ucID,$caddress,$ccity,$cpcode,$url,$ctel,$cfax,$gtype,$bname);
					
					if(mysqli_stmt_execute($stmt)) {
					unset($_SESSION['gtype']);
					echo "<div class='row'>
								<div class='col-lg-12'>";	
								echo "<br><br><div class='panel'>
											<br><h4>&emsp;Success!&ensp;University - College record created.&ensp;<a href='addboardcolun'>Create Next Record</a></h4><br>
										</div>";
								echo "<br><hr>
									<!-- Footer -->
											<ol class='breadcrumb'>
											<li>Copyright &copy; iMatr Canada Inc. 2018-<?php echo date('Y'); ?> All Rights Reserved</li>
											</ol>
								</div>
							</div>";
						exit;
					}
				}
			}
		}
?>
</div>
</body>
</html>