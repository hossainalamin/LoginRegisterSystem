<?php 
include'library/header.php';
include'library/user.php';
?>
<section id="body">
	<div class="card">
		<div class="card-header">
			<h2>Enter your number for verify</h2>
		</div>
		<div class="card-body">

				<?php 
				$txt="<div class='alert alert-success'><strong>Verification successfull.</strong></div>";
				echo $txt;
				?>
		</div>
	</div>
</section>
<?php include'library/footer.php';?>
