<?php
include'library/header.php';
include'library/user.php';
session::checkSession();
if(time()-session::get('current_timestamp')>60){
	session::destroy();
}
?>
<?php
session::init();
session_regenerate_id();
$loginmsg=session::get('loginmsg');
echo $loginmsg;
session::set("loginmsg",null);
?>

<section id="body">
    <div class="card">
        <div class="card-header">
            <h3>User list<span class="float-right">Welcome <strong><?php
              $name = session::get("name");
              echo $name;
              ?>
            </strong></span></h3>

        </div>
        <div class="card-body">
            <table class="table table-striped table-hover table-bordered">

                <th>serial</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
                <?php
                $user=new user();
                $userdata= $user->getUserData();

                if($userdata)
                {
                    $i=0;
                    foreach($userdata as $data)
                    {
                        $i++;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $data['name']?></td>
                    <td><?php echo $data['username']?></td>
                    <td><?php echo $data['email']?></td>
                    <td>
                        <a href="profile.php?id=<?php echo $data['id']?>"class="btn btn-primary">View</a>
                    </td>
                </tr>
                <?php } }else { ?>
                <tr><td colspan="5"><h2>No data found..</h2></td></tr>
                <?php } ?>

            </table>
        </div>
    </div>
</section>
<?php include'library/footer.php';?>
