<?php
session_start();
date_default_timezone_set("America/Toronto");
require_once '../dbcon.php';

require_once '../voda/classuseradm.php';
$user_home = NEW USER();
if(!$user_home->is_logged_in())
{
 $user_home->redirect('/index.php');
}

mysqli_set_charset($db,"utf8");
/* change character set to utf8 */
if (!mysqli_set_charset($db, "utf8mb4")) {
    //printf("Error loading character set utf8: %s\n", mysqli_error($db));
    exit();
} 
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

function validateEmailAddr($pemail) {
    return filter_var($pemail, FILTER_VALIDATE_EMAIL);
}

$mSuser = $_SESSION['muserSession'];

$error = false;
	
?>
<!DOCTYPE html>
<html>
  <head>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Imatr Canada Inc. Add a University of College</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

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
    <script src="js/bootstrap.min.js"></script>
	
	<script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>	

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
		
	<div class="row">
		<div class="col-lg-12">
			<h4>Create new university or college (Uncol) record</h4>
			<p>Official university or college emails are to be used by Data Entry Specialists for Uncol records.</p> 
			<br>
		</div>
	</div>
	<div class="row">
			<form role ="form" action="/voda/adduncolnc.php" method="POST">
			<fieldset>
			<div class="col-lg-5">
				<p><label>Enter Uncol's Email Address&ensp;*</label></p>
				<input type="text" class="input-block-level2" name="pemail" required/></p>
			</div>
			<div class="col-lg-5">
				<p><label>Re-Enter Uncol's Email Address&ensp;*</label></p>
				<input type="text" class="input-block-level2" name="pemail2" required/></p>
			</div>
	</div>
	<div class="row">
		<div clas="col-lg-12">
			</fieldset>
			<br>
				<p>* Required Fields</p>
			<br>
				<button class="btn btn-large btn-primary" type="submit" name="submit">Submit</button>&emsp;&emsp;
				<button class="btn btn-large btn-default" type="reset" value="reset">Reset</button>&emsp;&emsp;
		</div>
	</div>
	
		<?php
			if (isset($_POST['submit'])) {
				if(!$_SESSION['muserSession']) {
					 header("Location: /logout.php");
					 exit;
				} else {
					
					$Suser = $_SESSION['muserSession'];
					
					$pemail = cleanmysql($db, $_POST['pemail']);
					//validateEmailAddr($pemail);
					$pemail2 = cleanmysql($db, $_POST['pemail2']);
					//validateEmailAddr($pemail2);
					$cStatus = "C1";
					$date = date("Y-m-d");
					$date2 = date("Y-m-d H:i:s");
					
					if ($pemail == $pemail2) {
						$result = mysqli_query($db, "SELECT * FROM univcol WHERE email != '" . $pemail . "'" );
						$rowcount = mysqli_num_rows($result);
							if($rowcount != 1) {
										$lastID = $rowcount;
										$addID = $lastID + 1;
										$_SESSION['addID'] = $addID;
										$result2 = mysqli_query($db, "SELECT * FROM univcol WHERE email = '" . $pemail . "'" );
										$rowcount2 = mysqli_num_rows($result2);
										if($rowcount2 != 1) {
											$query = "INSERT INTO univcol (ucID, cStatus, cStatdate, email, cdate) VALUES ('" . $addID . "', '" . $cStatus . "', '" . $date . "', '" . $pemail . "', '" . $date2 . "')";		
											$result = mysqli_query($db, $query);	
												echo "<br><div class='panel'>
														<br><h4>&emsp;SUCCESS: UNIVERSITY - COLLEGE RECORD HAS BEEN CREATED.&ensp;<b>Proceed to <a href='/voda/adduncolnc_2.php'>Step 2</a></h4><br>
													  </div>";	
										} else {
											echo "<br><div class='panel'>
													<br><h4>&emsp;EMAIL ALREADY EXISTS.&ensp;DUPLICATE RECORD ENTRY.</h4><br>
												  </div>";
										}
							}
					} else {
						echo "<br><div class='panel'>
								<br><h4>&emsp;EMAILS ENTERED DO NOT MATCH.&ensp;PLEASE TRY AGAIN.</h4><br>
							 </div>";
					}
				}
			}
		?>			
	<br><hr>
	<!-- Footer -->
	<div class="row">
		<div class="col-lg-12">
			<ol class="breadcrumb">
			<li>Copyright &copy; Imatr Canada Inc. 2018-<?php echo date('Y'); ?> All Rights Reserved</li>
			</ol>
		</div>
	</div>
</div>

    
  </body>
</html>