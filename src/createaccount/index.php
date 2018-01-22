<?php include "../header.php"; ?>

<div class="container">

	<div class="row justify-content-center">
		<div class="col-md-6">

			<h1 class="page-title">Create an Account</h1>
					
			<form>
				<div class="form-group">
				<label for="form-username">Username</label>
				<input type="text" class="form-control" id="form-username" value="" name="username" />
				</div>
				<div class="form-group">
					<label for="form-password">Password</label>
					<input type="text" class="form-control" id="form-password" value="" name="pass" />
				</div>
				<div class="form-group">
					<label for="form-password-confirm">Confirm Password</label>
					<input type="text" class="form-control" id="form-password-confirm" value="" name="password-confirm" />
				</div>

				<button class="btn btn-defualt" id="form-create">Create Account</button>
			</form>
		</div>
	</div>
</div>


<?php include "../footer.php"; ?>

