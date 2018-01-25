<?php include "header.php"; ?>

<div class="container" id="login-container">

	<div class="row justify-content-center" >
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

<div class="container" id="loggedIn-container"  style="display:none; visibility:hidden;">

	<div class="row justify-content-center" >
		<div class="col-md-12">

			<h1 class="page-title" id="username" style="padding-bottom: 40px">Logged in as ""</h1>

      <label for="form-username">Search</label>
			<form class="form-inline">
				<div class="form-group">
				  <input type="text" class="form-control" id="search-username" value="" name="username" style="width:500px"/>
          <button class="btn btn-defualt" id="seach-submit"  style="margin-left:30px">Submit</button>
				</div>
			</form>

      <h2 style="padding-top:45px"> Results: </h2>

      <table class="table" id="search-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>John Smith</td>
            <td>(123) 456-7890</td>
            <td>john@smith.com</td>
            <td>This is an example contact</td>
          </tr>
        </tbody>
      </table>

		</div>
	</div>
</div>

<?php include "footer.php"; ?>
