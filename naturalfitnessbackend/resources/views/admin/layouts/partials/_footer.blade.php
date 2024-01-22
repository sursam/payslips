<script>
    var APP_URL = {!! json_encode(url('/')) !!};
    var TOAST_POSITION = 'top-right';
    var FIREBASE_API_KEY = "{{ config('services.firebase.apiKey') }}";
    var FIREBASE_AUTH_DOMAIN = "{{ config('services.firebase.authDomain') }}";
    var FIREBASE_PROJECT_ID = "{{ config('services.firebase.projectId') }}";
    var FIREBASE_STORAGE_BUCKET = "{{ config('services.firebase.storageBucket') }}";
    var FIREBASE_MESSAGING_SENDER_ID = "{{ config('services.firebase.messagingSenderId') }}";
    var FIREBASE_APP_ID = "{{ config('services.firebase.appId') }}";
    var FIREBASE_MEASUREMENT_ID = "{{ config('services.firebase.measurementId') }}";
</script>
<script src='https://www.gstatic.com/firebasejs/8.2.2/firebase.js'></script>
<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.6.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.6.0/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional

    const firebaseConfig = {
        apiKey: FIREBASE_API_KEY,
        authDomain: FIREBASE_AUTH_DOMAIN,
        projectId: FIREBASE_PROJECT_ID,
        storageBucket: FIREBASE_STORAGE_BUCKET,
        messagingSenderId: FIREBASE_MESSAGING_SENDER_ID,
        appId: FIREBASE_APP_ID,
        measurementId: FIREBASE_MEASUREMENT_ID
    };

    {{--  const firebaseConfig = {
        apiKey: "AIzaSyALVIvWgN8NauJnGzj6vPk_YrUb5Ox2vP4",
        authDomain: "daride-687d9.firebaseapp.com",
        projectId: "daride-687d9",
        storageBucket: "daride-687d9.appspot.com",
        messagingSenderId: "570343363974",
        appId: "1:570343363974:web:bae909afa1d1f70ae70807",
        measurementId: "G-Q1MVPJKZHW"
    };  --}}

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
        messaging.requestPermission().then(function () {
            return messaging.getToken()
        }).then(function(token) {
            $.ajax({
                type: "PATCH",
                url: baseUrl+"ajax/fcm-token",
                data: {'token': token},
                dataType: "json",
                success: function (response) {
                    console.log(response)
                }
            });

        }).catch(function (err) {
            console.log(`Token Error :: ${err}`);
        });
    }

    initFirebaseMessagingRegistration();

    messaging.onMessage(function({data:{body,title}}){
        new Notification(title, {body});
    });
</script>
{{--  <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrRtkwvBcSh3_uISG8CVAX2IqykHdQEP4&libraries=places"></script>  --}}
@if (Request::is('dashboard'))
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('constants.GOOGLE_MAP_API_KEY') }}&libraries=places"></script>
@endif
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11.6.14/dist/sweetalert2.all.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="//cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>

    <script src="{{ asset('assets/custom/js/flash.js') }}"></script>
    <script src="{{ asset('assets/custom/js/common.js') }}"></script>
@stack('scripts')
