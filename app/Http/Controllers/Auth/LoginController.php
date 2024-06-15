<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\FirebaseException;
use Illuminate\Validation\ValidationException;
use Auth;
use App\User;
use Kreait\Firebase\Auth\SignIn\FailedToSignIn;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    protected $auth;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FirebaseAuth $auth)
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
        $this->auth = $auth;
    }
    
    protected function login(Request $request)
    {
        try {
            $signInResult = $this->auth->signInWithEmailAndPassword(
                $request['email'],
                $request['password']
            );
            
            $user = new User($signInResult->data());
            $result = Auth::login($user);
            return redirect($this->redirectPath());
        } catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn $e) {
            $message = $e->getMessage();
            if ($message == 'INVALID_PASSWORD') {
                $message = 'Invalid Password';
            } elseif ($message == 'EMAIL_NOT_FOUND') {
                $message = 'Email Not Found!';
            }
            Session::put('message', $message);
            return redirect('login');
        } catch (InvalidToken $e) {
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);
        }
    }

    public function username()
    {
        return 'email';
    }

    public function handleCallback(Request $request, $provider)
    {
        $socialTokenId = $request->input('social-login-tokenId', '');
        try {
            $verifiedIdToken = $this->auth->verifyIdToken($socialTokenId);
            $user = new User();
            $user->displayName = $verifiedIdToken->getClaim('name');
            $user->email = $verifiedIdToken->getClaim('email');
            $user->localId = $verifiedIdToken->getClaim('user_id');
            Auth::login($user);
            return redirect($this->redirectPath());
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('login');
        } catch (InvalidToken $e) {
            return redirect()->route('login');
        }
    }
}
