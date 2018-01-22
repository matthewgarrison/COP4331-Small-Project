<?php include "header.php"; ?>

<div class="container">

	<div class="row justify-content-center">
		<div class="col-md-6">

			<h1 class="page-title">Contact Manager</h1>
					
			<form>
				<div class="form-group">
					<label for="form-username">Username</label>
					<input type="text" class="form-control" id="form-username" value="" name="username" />
				</div>
				<div class="form-group">
					<label for="form-password">Password</label>
					<input type="text" class="form-control" id="form-password" value="" name="password" />
				</div>
						
				<div><button class="btn btn-defualt" id="form-login">Login</button></div>
			</form>

			<p style="padding-top: 25px"><a href="/createaccount">Don't have an account? Create one.</a></p>
		</div>
	</div>
</div>

<?php include "footer.php"; ?>

