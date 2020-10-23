<?php 
include'library/header.php';
include'library/user.php';
?>
<?php
$user=new user();
if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['register']))
{
    $userReg=$user->registration($_POST);
}
?>
  <section id="body">
      <div class="card">
        <div class="card-header">
          <h2>User registration</h2>
        </div>
        <div class="card-body">
            <form action="" method="post"style="max-width:650px;margin: 0 auto;">
            <div class="form-group">
              <label for="name">Name:</label>
               <input type="text" name="name" class="form-control" placeholder="Enter name">
               <label for="username">Username:</label>
               <input type="text" name="username" class="form-control" placeholder="Enter username">
               <label for="email">Email:</label>
               <input type="text" name="email" class="form-control" placeholder="Enter Email">
               <label for="email">Phone:</label>
               <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
                <label for="password">Password:</label>
               <input type="text" name="password" class="form-control" placeholder="Enter Password"> 
               <input type="submit"class="btn btn-primary mt-2" value="Register" name="register">
            </div>
            <?php
            if(isset($userReg))
            {
                echo $userReg;
            }
            
            ?>            
            </form>

        </div>
      </div>
 </section>   
<?php include'library/footer.php';?>