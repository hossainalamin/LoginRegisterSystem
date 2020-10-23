<?php 
include'library/header.php';
include'library/user.php';
?>
<?php
$user=new user();
if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['verify']))
{
    $userVerify=$user->verify($_POST);
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
              <label for="phone">Phone:</label>
               <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
               <input type="submit"class="btn btn-primary mt-2" value="Verify" name="verify">
            </div> 
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