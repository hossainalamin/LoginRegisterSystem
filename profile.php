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
}
$user=new user();
if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['update']))
{
    $update=$user->userUpdate($id,$_POST);
}
?>
<section id="body">
    <div class="card">
        <div class="card-header">
            <a href="index.php" class="btn btn-primary float-right">Back</a>
            <h2>User Profile</h2>
        </div>
        <div class="card-body">
           <?php
            $userdata=$user->getDataById($id);  
                if($userdata)
                {
            ?>
            <form action="" method="post"style="max-width:600px;margin: 0 auto;">
                <div class="form-group">
                    <label for="email">Name:</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $userdata->name;?>">
                    <label for="email">Username:</label>
                    <input type="text" name="username" class="form-control"value="<?php echo $userdata->username;?>">
                    <label for="email">Email:</label>
                    <input type="text" name="email" class="form-control"value="<?php echo $userdata->email;?>">
                    <?php } ?>
                           
                           
                    <?php
                    if(isset($update))
                    {
                    echo"<br>";
                    echo $update;
                    }
                               
                    ?>
                    <?php
                    $sesid=session::get('id');
                    if($id==$sesid)
                    {
                    ?>
                    <input type="submit" class="btn btn-success mt-2" value="Update" name="update">
                    <a href="changepass.php?id=<?php echo $id;?>" class="btn btn-primary mt-2">Change Password</a>
                </div>
            </form>
        <?php  } ?>
        </div>
    </div>
</section>
<?php include'library/footer.php';?>
