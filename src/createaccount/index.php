<?php include "../header.php"; ?>

<div class="container">

	<div class="row justify-content-center">
		<div class="col-md-6">

			<h1 class="page-title">Create Account</h1>
					
			<form>
				<div class="form-group">
				<label for="form-name">Username:</label>
				<input type="text" class="form-control" id="form-name" placeholder="Jane Doe" value="" name="name" />
			</div>
			<div class="form-group">
				<label for="form-pid">Password</label>
				<input type="text" class="form-control" id="form-ucfid" placeholder="1234567" value="" name="ucfid" />
			</div>
			</form>

			<p><a href="/login">Create Account</a></p>
		</div>
	</div>
</div>


<?php include "../footer.php"; ?>

