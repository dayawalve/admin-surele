<script src="{{ url('/') }}/public/js/admin/jquery.min.js"></script>
<script src="{{ url('/') }}/public/js/admin/plugins.bundle.js"></script>
<script src="{{ url('/') }}/public/js/admin/scripts.bundle.js"></script>
<script src="{{ url('/') }}/public/js/admin/widgets.bundle.js"></script>
<script src="{{ url('/') }}/public/js/admin/datatables.bundle.js"></script>
<script src="{{ url('/') }}/public/js/admin/bvalidator/jquery.bvalidator.min.js"></script>
<script src="{{ url('/') }}/public/js/admin/bvalidator/default.min.js"></script>
<script src="{{ url('/') }}/public/js/admin/bvalidator/gray.js"></script>
<script src="{{ url('/') }}/public/js/profile/signin-methods.js"></script>
<script src="{{ url('/') }}/public/js/profile/profile-details.js"></script>
<script src="{{ url('/') }}/public/js/profile/deactivate-account.js"></script>
<script src="{{ url('/') }}/public/js/profile/general.js"></script>
<script src="{{ url('/') }}/public/js/custom.js"></script>
<script src="{{ url('/') }}/public/js/ajax.js"></script>
<script>
    $(document).ready(function () {
        $('#FormId').bValidator();
    });
</script>
<script>
	// Start alert code
	@if(Session::has('success'))
		toastr.options = {
			"closeButton": false,
			"debug": false,
			"newestOnTop": true,
			"progressBar": true,
			"positionClass": "toastr-top-right",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};
		toastr.success("{{ session('success') }}", "Success");
	@endif

	@if(Session::has('error'))
		toastr.options = {
			"closeButton": false,
			"debug": false,
			"newestOnTop": true,
			"progressBar": true,
			"positionClass": "toastr-top-right",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};
		toastr.error("{{ session('error') }}", "Error");
	@endif

	@if (count($errors) > 0)
		var err = {!!$errors!!};
		$.each(err, function( index, value ) {
			toastr.options = {
				"closeButton": false,
				"debug": false,
				"newestOnTop": true,
				"progressBar": true,
				"positionClass": "toastr-top-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			};
			toastr.error(value,'Error');
		});

	@endif
	// end alert code
</script>