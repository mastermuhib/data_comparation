
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="../../../">
		<meta charset="utf-8" />
		<title>IPEKA UKS | Login CMS</title>
		<meta name="description" content="Login" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Custom Styles(used by this page)-->
		<link href="{{URL::asset('assets')}}/css/pages/login/login-4.css" rel="stylesheet" type="text/css" />
		<!--end::Page Custom Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="{{URL::asset('assets')}}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{URL::asset('assets')}}/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{URL::asset('assets')}}/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="{{URL::asset('assets')}}/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="{{URL::asset('assets')}}/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
		<link href="{{URL::asset('assets')}}/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
		<link href="{{URL::asset('assets')}}/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="{{URL::asset('assets')}}/images/favicon.png" />
		<style type="text/css">
        .field-icon {
		    cursor: pointer;
		    float: right;
		    margin-top: -45px;
		    position: relative;
		    z-index: 2;
		    margin-right: 15px;
		}
    </style>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading" style="background: white;">
		<!--begin::Main-->
		<div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="text-center mb-4">
                            <a href="index.html" class="auth-logo mb-5 d-block">
                                <img src="{{URL::asset('assets')}}/images/ipeka.png" alt="" height="200" class="logo logo-dark">  
                            </a>
                            <h4>Sign in</h4>
                            <p class="text-muted mb-4">Sign in to continue to IPEKA UKS Admin.</p>  
                        </div>
                        <div class="card">
                            <div class="card-body p-4">
                                @if ($errors->any())
                                <div class="alert alert-danger form-group">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="p-3">
                                    <form class="form" novalidate="novalidate" method="post" action="/login">@csrf
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <div class="input-group mb-3 bg-soft-light rounded-3">
                                                
                                                <input type="text" class="form-control form-control-lg border-light bg-soft-light" placeholder="Enter Username" name="username" required aria-label="Enter Username" aria-describedby="basic-addon3">
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Password</label>
                                            <div class="input-group mb-3 bg-soft-light rounded-3">
                                                
                                                <input type="password" class="form-control form-control-lg border-light bg-soft-light" placeholder="Enter Password" aria-label="Enter Password" aria-describedby="basic-addon4" name="password" required>
                                                
                                            </div>
                                        </div>

                                        <div class="form-check mb-4 d-none">
                                            <input type="checkbox" class="form-check-input" id="remember-check">
                                            <label class="form-check-label" for="remember-check">Remember me</label>
                                        </div>

                                        <div class="text-center">
                                            <button class="btn btn-primary waves-effect waves-light mt-10" type="submit">Log in</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!--end::Main-->
		<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{URL::asset('assets')}}/plugins/global/plugins.bundle.js"></script>
		<script src="{{URL::asset('assets')}}/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="{{URL::asset('assets')}}/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Scripts(used by this page)-->
		<script src="{{URL::asset('assets')}}/js/pages/custom/login/login.js"></script>
		<!--end::Page Scripts-->
		<script type="text/javascript">
            $(".toggle-password").click(function() {
              $(this).toggleClass("fa-eye fa-eye-slash");
              var input = $($(this).attr("toggle"));
              if (input.attr("type") == "password") {
                input.attr("type", "text");
              } else {
                input.attr("type", "password");
              }
            });
            function show_toast(message, type) {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
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
                if (type == 1) {
                    toastr.success(message, "Notification");
                } else {
                    toastr.error(message, "Error Notification")
                }

            }
        </script>
	</body>
	<!--end::Body-->
</html>