<script>
    var APP_URL = {!! json_encode(url('/')) !!};
    var TOAST_POSITION = 'top-right';
</script>
<script src="{{ asset('assets/js/app.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('assets/js/jquery.min.js') }}" ></script>
<script src="//cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
<script src="{{ asset('assets/custom/js/flash.js') }}"></script>
<script src="//www.google.com/recaptcha/api.js?render={{ config('captcha.sitekey') }}" defer></script>
@stack('scripts')
