@extends('dashboard.authBase')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                    <h1>Login</h1>
                    <p class="text-muted">Sign In to your account</p>
                    @if (Session::has('message'))
                        <p class="alert alert-danger">{{ Session::get('message') }}</p>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            <svg class="c-icon">
                                <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-user"></use>
                            </svg>
                            </span>
                        </div>
                        <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            <svg class="c-icon">
                                <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-lock-locked"></use>
                            </svg>
                            </span>
                        </div>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" placeholder="{{ __('Password') }}" name="password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="row">
                        <div class="col-6">
                            <button class="btn btn-primary px-4" type="submit">{{ __('Login') }}</button>
                        </div>
                        </form>
                        <!--<div class="col-6 text-right">-->
                        <!--    <a href="{{ route('password.request') }}" class="btn btn-link px-0">{{ __('Forgot Your Password?') }}</a>-->
                        <!--</div>-->
                        </div>
                    </div>
                </div>
                <!--<div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">-->
                <!--    <div class="card-body text-center">-->
                <!--    <div>-->
                <!--        <h2>Sign up</h2>-->
                <!--        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>-->
                <!--        @if (Route::has('password.request'))-->
                <!--        <a href="{{ route('register') }}" class="btn btn-primary active mt-3">{{ __('Register') }}</a>-->
                <!--        @endif-->
                <!--    </div>-->
                <!--    </div>-->
                <!--</div>-->
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-auth.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
// Initialize Firebase
var config = {
    // This is the variable you got from Firebase's Firebase SDK snippet. It includes values for apiKey, authDomain, projectId, etc.
};
firebase.initializeApp(config);
var facebookProvider = new firebase.auth.FacebookAuthProvider();
var googleProvider = new firebase.auth.GoogleAuthProvider();
var facebookCallbackLink = '/login/facebook/callback';
var googleCallbackLink = '/login/google/callback';
async function socialSignin(provider) {
    var socialProvider = null;
    if (provider == "facebook") {
        socialProvider = facebookProvider;
        document.getElementById('social-login-form').action = facebookCallbackLink;
        console.log("facebook");
    } else if (provider == "google") {
        socialProvider = googleProvider;
        document.getElementById('social-login-form').action = googleCallbackLink;
    } else {
        return;
    }
    firebase.auth().signInWithPopup(socialProvider).then(function(result) {
        console.log("return");
        console.log(result);
        result.user.getIdToken().then(function(result) {
            document.getElementById('social-login-tokenId').value = result;
            document.getElementById('social-login-form').submit();
        });
    }).catch(function(error) {
        // do error handling
        console.log(error);
    });
}
</script>
@endsection