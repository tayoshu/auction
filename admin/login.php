<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
}
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	html, body{
		height: 100%;
	}
	body{
		margin: 0;
		min-height: 100vh;
		display: flex;
		align-items: center;
		justify-content: center;
		background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
	}
	#main{
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: center;
		padding: 1.5rem;
	}
	.login-card{
		width: 100%;
		max-width: 380px;
		background: #fff;
		border: none;
		border-radius: 14px;
		box-shadow: 0 20px 50px rgba(0,0,0,.35);
	}
	.login-card .card-body{
		padding: 2.5rem 2rem;
	}
	.login-brand{
		text-align: center;
		margin-bottom: 1.75rem;
	}
	.login-brand h1{
		font-size: 1.3rem;
		font-weight: 700;
		color: #0f172a;
		margin: 0;
	}
	.login-brand p{
		color: #64748b;
		font-size: .85rem;
		margin: .4rem 0 0;
	}
	.login-card label{
		font-weight: 600;
		color: #334155;
		font-size: .85rem;
	}
	.login-card .form-control{
		border-radius: 8px;
		padding: .65rem .8rem;
		height: auto;
	}
	.login-card .btn-login{
		width: 100%;
		border-radius: 8px;
		padding: .6rem;
		font-weight: 600;
		margin-top: .75rem;
	}
</style>

<body>

  <main id="main">
  		<div class="card login-card">
  			<div class="card-body">
  				<div class="login-brand">
  					<h1><?php echo $_SESSION['system']['name'] ?></h1>
  					<p>Admin Panel — Sign in to continue</p>
  				</div>
  				<form id="login-form" >
  					<div class="form-group">
  						<label for="username" class="control-label">Username</label>
  						<input type="text" id="username" name="username" class="form-control" autofocus>
  					</div>
  					<div class="form-group">
  						<label for="password" class="control-label">Password</label>
  						<input type="password" id="password" name="password" class="form-control">
  					</div>
  					<button class="btn btn-primary btn-login">Login</button>
  				</form>
  			</div>
  		</div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>