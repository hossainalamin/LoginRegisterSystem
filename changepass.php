<?php
include'library/header.php'; 
include'library/user.php'; 
session::checkSession();
if(time()-session::get('current_timestamp')>60){
	session::destroy();
}
?>
<?php
if(isset($_GET['id']))
{
    $id = (int)$_GET['id'];
    $sesid=session::get('id');
    if($id!=$sesid)
    {
        header("location:index.php");
    }
}
$user=new user();
if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['updatepass']))
{
    $updatepass=$user->userPassword($id,$_POST);
}
?>
<section id="body">
    <div class="card">
        <div class="card-header">
            <a href="index.php" class="btn btn-primary float-right">Back</a>
            <h2>Password Change</h2>
        </div>
        <div class="card-body">
            <form action="" method="post"style="max-width:600px;margin: 0 auto;">
                <div class="form-group">
                    <label for="old pass">Old password:</label>
                    <input type="password" name="old" class="form-control">
                    <label for="new pass">New Password:</label>
                    <input type="password" name="new" class="form-control">    

                            <?php
                            if(isset($updatepass))
                            {
                                echo"<br>";
                                echo $updatepass;
                            }
                               
                            ?>
                    <input type="submit" class="btn btn-success mt-2" value="Update" name="updatepass">
                </div>
            </form>
        </div>
    </div>
</section>
<?php include'library/footer.php';?>
