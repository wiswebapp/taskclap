<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.linkcss')
</head>

<body class="home-page-three">
	<div id="app" class="main-wrapper">

		<!-- Header -->
		@include('layouts.header')
		<!-- /Header -->

        @yield('content')

        <!-- Footer -->
        @include('layouts.footer')
        <!-- /Footer -->

		<!-- Cursor -->
		<div class="mouse-cursor cursor-outer"></div>
		<div class="mouse-cursor cursor-inner"></div>
		<!-- /Cursor -->

		<!-- Delete Account -->
		<div class="modal fade custom-modal" id="del-account">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header border-bottom-0 justify-content-between">
						<h5 class="modal-title">Delete Account</h5>
						<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x"></i></button>
					</div>
					<div class="modal-body pt-0">
						<div class="write-review">
							<form action="login.html">
								<p>Are you sureyou want to delete This Account? To delete your account, Type your password.</p>
								<div class="form-group">
									<label class="col-form-label">Password</label>
									<div class="pass-group">
										<input type="password" class="form-control pass-input" placeholder="*************">
										<span class="toggle-password feather-eye"></span>
									</div>
								</div>
								<div class="modal-submit text-end">
									<a href="#" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</a>
									<button type="submit" class="btn btn-danger">Delete Account</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('layouts.scripts')
</body>
</html>
