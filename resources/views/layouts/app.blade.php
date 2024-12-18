<!--
=========================================================
* Soft UI Dashboard - v1.0.3
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>

@if (\Request::is('rtl'))
<html dir="rtl" lang="ar">
@else
<html lang="en">
@endif

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('') }}assets/img/ibarcode.png">
	<link rel="icon" type="image/png" href="{{ asset('') }}assets/img/ibarcode.png">
	<title>
		BARCODE APP
	</title>
	<!--     Fonts and icons     -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<!-- Nucleo Icons -->
	<link href="{{ asset('') }}assets/css/nucleo-icons.css" rel="stylesheet" />
	<link href="{{ asset('') }}assets/css/nucleo-svg.css" rel="stylesheet" />
	<!-- Font Awesome Icons -->
	<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
	<link href="{{ asset('') }}assets/css/nucleo-svg.css" rel="stylesheet" />
	<!-- CSS Files -->
	<link id="pagestyle" href="{{ asset('') }}assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />

	<!-- Select2 -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

	<!-- <style>
        .select2-container--default .select2-selection--single {
            border: none;
            font-size: small;
        }

        .select2-container--default .select2-selection--multiple {
            border: none;
            border-bottom: 1px solid #ced4da;
            border-radius: 0px;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: none;
            border-bottom: 1px solid #ced4da;
            border-radius: 0px;
        }
    </style> -->
	
	<style>
		.dataTables_info {
			font-size: 14px;
			color: #6c757d;
			margin-top: 10px;
		}

		.dataTables_filter {
			float: right;
		}

		.dataTables_filter input {
			width: 200px;
			padding: 5px;
		}
	</style>
</head>

<body class="g-sidenav-show  bg-gray-100 {{ (\Request::is('rtl') ? 'rtl' : (Request::is('virtual-reality') ? 'virtual-reality' : '')) }} ">
	@auth
	@yield('auth')
	@endauth
	@guest
	@yield('guest')
	@endguest

	@if(session()->has('success'))
	<div x-data="{ show: true}"
		x-init="setTimeout(() => show = false, 4000)"
		x-show="show"
		class="position-fixed bg-success rounded right-3 text-sm py-2 px-4">
		<p class="m-0">{{ session('success')}}</p>
	</div>
	@endif
	<!--   Core JS Files   -->
	<script src="{{ asset('') }}assets/js/core/popper.min.js"></script>
	<script src="{{ asset('') }}assets/js/core/bootstrap.min.js"></script>
	<script src="{{ asset('') }}assets/js/plugins/perfect-scrollbar.min.js"></script>
	<script src="{{ asset('') }}assets/js/plugins/smooth-scrollbar.min.js"></script>
	<script src="{{ asset('') }}assets/js/plugins/fullcalendar.min.js"></script>
	<script src="{{ asset('') }}assets/js/plugins/chartjs.min.js"></script>
	<script src="{{ asset('') }}assets/js/core/choices.min.js"></script>

	@stack('rtl')
	@stack('dashboard')
	<script>
		var win = navigator.platform.indexOf('Win') > -1;
		if (win && document.querySelector('#sidenav-scrollbar')) {
			var options = {
				damping: '0.5'
			}
			Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
		}
	</script>

	<!-- Github buttons -->
	<script async defer src="https://buttons.github.io/buttons.js"></script>
	<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
	<script src="{{ asset('') }}assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>

	<!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

</html>