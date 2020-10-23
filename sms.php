<?php 
include'library/header.php';
include'library/user.php';
?>
<?php
$user=new user();
if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['register']))
{
    $userVerify=$user->confirm($_POST);
}
?>
    <?php 
		if(isset($_GET['phone'])){
			$phone = $_GET['phone'];
			
		}
	?> 
  <section id="body">
      <div class="card">
        <div class="card-header">
          <h2>Enter your number for verify</h2>
        </div>
        <div class="card-body">
            <form action="" method="post"style="max-width:650px;margin: 0 auto;">
            <div class="form-group">
              <label for="phone">OTP:</label>
               <input type="text" name="otp" class="form-control" placeholder="Enter otp number">
               <input type="hidden" name="phone" class="form-control" value="<?php echo $phone;?>">
               <input type="submit"class="btn btn-primary mt-2" value="Confirm" name="register">
            </div> 
            <?php 
				if(isset($_GET['msg'])){
					$msg = $_GET['msg'];
					echo $msg;
				}
			?>
			<?php 
				if(isset($userVerify)){
					echo $userVerify;
				}
			?>         
            </form>
        </div>
      </div>
 </section>   
<?php include'library/footer.php';?>