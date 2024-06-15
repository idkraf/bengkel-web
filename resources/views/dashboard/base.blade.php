<!DOCTYPE html>
<html lang="en">
  <head><meta charset="shift_jis">
    <base href="./">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>Cabi Admin Panel</title>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="public/assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Icons-->
    <link href="{{ asset('public/css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
    <!-- Main styles for this application-->
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    @yield('css')

    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=G-76M97WTCEH"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      // Shared ID
      gtag('config', 'G-76M97WTCEH');
      // Bootstrap ID
      gtag('config', 'G-76M97WTCEH');
    </script>

    <link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet">
      <!-------------------Firebase OTP--------------------------->
<script src="https://www.gstatic.com/firebasejs/7.21.1/firebase.js"></script>
<script>
    var config = {
      apiKey: "AIzaSyBLlZpGVbfGc24EgTtoH1M01w6WK-azNJ0",
      authDomain: "cabi-bc4cd.firebaseapp.com",
      databaseURL: "https://cabi-bc4cd-default-rtdb.asia-southeast1.firebasedatabase.app",
      projectId: "cabi-bc4cd",
      storageBucket: "cabi-bc4cd.appspot.com",
      messagingSenderId: "750080907106",
      appId: "1:750080907106:web:9bf5c542675ccaee1f7e3b",
      measurementId: "G-76M97WTCEH"
     };
    firebase.initializeApp(config);
</script>
<script src="https://cdn.firebase.com/libs/firebaseui/2.3.0/firebaseui.js"></script>
<link type="text/css" rel="stylesheet" href="https://cdn.firebase.com/libs/firebaseui/2.3.0/firebaseui.css" />
  </head>
  <body class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
      @include('dashboard.shared.nav-builder')
      @include('dashboard.shared.header')
      <div class="c-body">
        <main class="c-main">
          @yield('content') 
        </main>
        @include('dashboard.shared.footer')
      </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('js/coreui-utils.js') }}"></script>
    @yield('javascript')
          <!-- firebase otp2 -->

  <script>
    function getUiConfig() {
    return {
        'callbacks': {
            'signInSuccess': function(user, credential, redirectUrl) {
              console.log(user);
            handleSignedInUser(user);
            return false;
            }
        },
      'signInFlow': 'popup',
      'signInOptions': [
            //firebase.auth.GoogleAuthProvider.PROVIDER_ID,
            //firebase.auth.FacebookAuthProvider.PROVIDER_ID,
            //firebase.auth.TwitterAuthProvider.PROVIDER_ID,
            //firebase.auth.GithubAuthProvider.PROVIDER_ID,
            //firebase.auth.EmailAuthProvider.PROVIDER_ID,
            {
                provider: firebase.auth.PhoneAuthProvider.PROVIDER_ID,
                recaptchaParameters: {
                    type: 'image', 
                    size: 'invisible',
                    badge: 'bottomleft' 
                },
                defaultCountry: 'ID', 
                defaultNationalNumber: '1234567890',
                loginHint: '+621234567890'
            }
          ],
      'tosUrl': 'https://www.google.com'
    };
  }

  var ui = new firebaseui.auth.AuthUI(firebase.auth());
  
  var handleSignedInUser = function(user) {
    document.getElementById('user-signed-in').style.display = 'block';
    document.getElementById('user-signed-out').style.display = 'none';
    document.getElementById('phone').textContent = user.phoneNumber;
    document.getElementById('mobile_no').value = user.phoneNumber;
    document.getElementById('sign-out').click();
  };

  var handleSignedOutUser = function() {
    document.getElementById('user-signed-in').style.display = 'none';
    document.getElementById('user-signed-out').style.display = 'block';
    ui.start('#firebaseui-container', getUiConfig());
  };

  firebase.auth().onAuthStateChanged(function(user) {
    document.getElementById('loading').style.display = 'none';
    document.getElementById('loaded').style.display = 'block';
    user ? handleSignedInUser(user) : handleSignedOutUser();
  });

  var initApp = function() {
    document.getElementById('sign-out').addEventListener('click', function() {
    firebase.auth().signOut();
    });
  };
  window.addEventListener('load', initApp);
</script>
<!-- end firebase otp2 -->
  </body>
</html>
