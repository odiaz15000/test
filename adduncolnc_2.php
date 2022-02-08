<?php
session_start();
require_once '../dbcon.php';

require_once '../voda/classuseradm.php';
$user_home = NEW USER();
if(!$user_home->is_logged_in())
{
 $user_home->redirect('/index.php');
}

mysqli_set_charset($db,"utf8");
/* change character set to utf8 */
 
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

$mSuser = $_SESSION['muserSession'];

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

    <title>Imatr Canada Inc. Add University - College Step 2</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/imatrcacss.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
    padding-top: 40px;
}
.input-block-level1 {
	width: 800px;
	font-size: 15px;
	padding: 4px 4px;
}
.input-block-level2 {
	width: 225px;
	font-size: 15px;
	padding: 4px 4px;
}
.input-block-level3 {
	width: 120px;
	font-size: 15px;
	padding: 4px 4px;
}
.input-block-level4 {
	width: 200px;
	font-size: 15px;
	padding: 4px 4px;
}
.input-block-level6 {
	width: 325px;
	font-size: 15px;
	padding: 4px 4px;
}
input [type=text], select {
	font-size: 16px;
	padding: 4px 4px;
	font-weight: normal;
}
h5 {
	font-size: 14px;
}
hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid #D3D3D3;
    margin: 1em 0;
    padding: 0; 
}
.input_container {
	height: 30px;
	float: left;
}
.input_container input {
	height: 20px;
	width: 350px;
	padding: 4px;
	border: 1px solid #cccccc;
	border-radius: 0;
}
.input_container ul {
	width: 350px;
	border: 1px solid #eaeaea;
	position: absolute;
	z-index: 9;
	background: white;
	list-style: none;
}
.input_container ul li {
	padding: 4px;
}
.input_container ul li:hover {
	background: #eaeaea;
	padding: 4px;
}
#city_list_id {
	display: none;
}
#city_id {
	height: 29px;
	width: 350px;
}
select {
	font-size: 15px;
}
</style>
<script>
// autocomplet : this function will be executed every time we change the text for city
    function autocomplet() {
	var min_length = 0; // min caracters to display the autocomplete
	var keyword = $('#city_id').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: '/ajax_cityrefresh.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#city_list_id').show();
				$('#city_list_id').html(data);
			}
		});
	} else {
		$('#city_list_id').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item(item) {
	// change input value
	$('#city_id').val(item);
	// hide proposition list
	$('#city_list_id').hide();
}   
</script>
</head>
<body body style="background-color:#eeeeee">
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
						<a href="addboardrevuncol.php">DB Management Review</a>
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
<div class="container">
		<div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">
				<img style="float:right" src="/logos/imatrlogo75grBH.png" class="img-responsive" alt="error" />
				<span class="fa-stack fa-1x">
                <i class="fa fa-folder-open fa-stack-3x text-primary"></i></span>
				Add to Database&emsp;<small>Create Expanded Uncol Record</small>	
                </h2>
			</div>
	</div>
		<!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="/voda/mdashboard.php">Admin Dashboard</a>
                    </li>
                    <li><a href="/voda/addboardcolun.php">DB Management CRUD</a></li><li class="active">Create Uncol Record</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
		
<div class="container">
	<div class="row">							
		<div class='form-group'>
		<form role ='form' action='/voda/adduncolnc_2.php' method='POST'>
		<fieldset>
			<h3>Step 2 - Input Further Details Below<br><br>
			<div class='col-md-4'>
				<p><label>Uncol's Name&ensp;*</label></p>
				<input type="text" class="input-block-level6" name="ucname" required pattern='^[-a-zA-Z./' ]+$' /></p>
			</div>
			<div class='col-md-3'>
				<p><label>Uncol Contact First Last Name</label></p>
				<input type="text" class="input-block-level2" name="pcname" /></p>
			</div>
			<div class='col-md-3'>
				<p><label>Uncol's Province / Territory&ensp;*</label></p>
				<p><select id=province' name='provter' class="input-block-level2" required pattern='^[a-zA-Z ]+$'></p>
						<option value=''></option>
						<p><option value='Alberta'>Alberta</option></p>
						<p><option value='British Columbia'>British Columbia</option></p>
						<p><option value='Manitoba'>Manitoba</option></p>
						<p><option value='New Brunswick'>New Brunswick</option></p>
						<p><option value='Newfoundland Labrador'>Newfoundland and Labrador</option></p>
						<p><option value='Nova Scotia'>Nova Scotia</option></p>
						<p><option value='Ontario'>Ontario</option></p>
						<p><option value='Prince Edward Island'>Prince Edward Island</option></p>
						<p><option value='Quebec'>Quebec</option></p>
						<p><option value='Saskatchewan'>Saskatchewan</option></p>
						<p><option value='Northwest Territories'>Northwest Territories</option></p>
						<p><option value='Nunavut'>Nunavut</option></p>
						<p><option value='Yukon'>Yukon</option></p>
					</select>
			</div>
	</div>
	</div>
	<div class="row">
			<div class='col-md-4'>
				<p><label>Uncol Type&ensp;*</label></p>
				<select name='otype' class="input-block-level6" required pattern='^[A-Z]+$'>	
					<option value=''></option>
					<option value='C'>College</option>
					<option value='U'>Universtiy</option>
				</select>									
			</div>
			<div class='col-md-4'>
				<p><label>Government Type&ensp;*</label></p>
				<select name='gtype' class="input-block-level2" required pattern='^[A-Za-z]+$'>	
					<option value=''></option>
					<option value='Board of Governors'>Board of Governors</option>
					<option value='Student Body'>Student Body</option>
				</select>									
			</div>
		</div>
			</fieldset>
			<br>
				<p>* Required Fields</p>
				<br><br>
				<button class='btn btn-large btn-primary' type='submit' name='submit'>Submit</button>&emsp;&emsp;
				<button class='btn btn-large btn-default' type='reset' value='reset'>Reset</button>&emsp;&emsp;	
			</form>
		</div>
	</div>					

	
	<?php
		if(isset($_POST['submit'])) {
			
			$ucname = cleanmysql($db, $_POST['ucname']);
			$pcname = cleanmysql($db, $_POST['pcname']);
			$provter = cleanmysql($db, $_POST['provter']);
			$_SESSION['provterep'] = $provter;
			$uctype = cleanmysql($db, $_POST['otype']);
			$gtype = cleanmysql($db, $_POST['gtype']);
			$_SESSION['gtype'] = $gtype;
			$country = "Canada";
			$ucID = $_SESSION['addID'];
				
			$query = "UPDATE univcol SET ucID=?, userID=?, ucname=?, contact=?, type=?, prov=?, country=? WHERE ucID='" . $ucID . "'";
			
			if($stmt = mysqli_prepare($db,$query)) {
			
				mysqli_stmt_bind_param($stmt,"iisssss",$ucID,$mSuser,$ucname,$pcname,$uctype,$provter,$country);
			
				if(mysqli_stmt_execute($stmt)) {
						
				echo "<div class='container'>
						<div class='form-group'>
						<br>
						<div class='row'>
						<form role ='form' action='/voda/adduncolnc_3.php' method='POST'>
						<fieldset>
						<br>
						<h3>University - College ".$_SESSION['gtype']." Office Information</h3><br>";
							if ($_SESSION['gtype'] == "Student Body") {	
								echo "<div class='col-md-4'>
									<p><label>Student Government Name&ensp;*</label></p>
									<input type='text' name='bname' class='input-block-level1' required pattern='^[-a-zA-Z.' ]+$' maxlength='175' title='Only numbers, letters, space, hyphen and period accepted ie 234 Main Street West. Capital letter(s) on street name(s). Max (25) characters.'>	
								</div>";
							}
					echo "</div>
					<br>
					<div class='row'>
						<div class='col-md-4'>
							<p><label>Address&ensp;*</label></p>
						<input type='text' name='caddress' class='input-block-level6' required pattern='^[-A-Za-z0-9.' ]+$' maxlength='100' title='Only numbers, letters, space, hyphen and period accepted ie 234 Main Street West. Capital letter(s) on street name(s). Max (25) characters.'>	
						</div>
						<div class='col-md-4'>
							<p><label>City / Town &ensp;*</label></p>
							<div class='input_container'>
									<input type='text' id='city_id' name='ccity'  class='input-block-level2' onkeyup='autocomplet()'>
									<ul id='city_list_id'></ul>
							</div>
						</div>	
						<div class='col-md-1'>
							<p><label>PCode&ensp;*</label></p>
							<input type='text' name='cpcode' class='input-block-level3' required pattern='^[a-zA-Z0-9 ]+$' maxlength='8' title='Only numbers, letters, space, hyphen and period accepted ie 234 Main Street West. Capital letter(s) on street name(s). Max (25) characters.'>	
						</div>
					 </div>
					<div class='row'>
					<br>
						<div class='col-md-3'>
							<p><label>Tel&ensp;*</label></p>
							<input type='tel' name='ctel' class='input-block-level4' required pattern='^[0-9]+\s[0-9]+\s[0-9]+$' maxlength='12' title='Only numbers accepted ie 416 456 7890'>
						</div>
						<div class='col-md-3'>
							<p><label>Fax</label>&emsp;</p>
							<input type='tel' name='cfax' class='input-block-level4' pattern='^[0-9]+\s[0-9]+\s[0-9]+$' maxlength='12' title='Only numbers accepted ie 416 456 7890'>
						</div>
					</div>
					<div class='row'>
					<br>
						<div class='col-md-8'>
							<p><label>URL&ensp;*</label></p>
							<input type='text' name='url' class='input-block-level1' required>
						</div>
					</div>
					</fieldset>
					<br>
						<p>* Required Fields</p>
						<br><br>
						<button class='btn btn-large btn-primary' type='submit' name='submit2'>Submit</button>&emsp;&emsp;
						<button class='btn btn-large btn-default' type='reset' value='reset2'>Reset</button>&emsp;&emsp;	
					</form>
				</div>";
				
				}
			}
		}
		?>
<br>	
<!-- Footer -->
<div class="container">
	<div class="row">
		<div class="col-lg-12">
		<hr>
			<ol class="breadcrumb">
			<li>Copyright &copy; iMatr Canada Inc. 2018-<?php echo date('Y'); ?> All Rights Reserved</li>
			</ol>
		</div>
	</div>
</div>

</body>
</html>