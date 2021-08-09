<?php

namespace App\Http\Controllers\Auth;


use Adldap\Adldap;
use Adldap\Schemas\ActiveDirectory;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function attemptLogin(Request $request)
    {
//        Auth::loginUsingId(1, true);

        $login = $request->email;
        $pass = $request->password;
        $remember = $request->remember;
        try {
            $config = [
                'hosts' => config('ldap.hosts'),
                'base_dn' => config('ldap.base_dn'),
                'username' => $login . config('ldap.suffix'),
                'password' => $pass,
                'schema' => ActiveDirectory::class
            ];

            $ad = new Adldap();
            $ad->addProvider($config);
            $provider = $ad->connect();
        } catch (\Exception $e) {
            return false;
        }

        $manager = $provider->search()->where('samaccountname', '=', $login)->first();
        $group = $this->checkGroup($manager);

        if (!$group) return false;

        $user = User::query()->where('login', $login)->first();

        if (is_null($user)) {
            User::create(
                [
                    'name' => $manager->name[0],
                    'email' => $manager->mail[0],
                    'login' => $login,
                    'role' => $group,
                ]
            );
            $user = User::query()->where('login', $login)->first();
        } else {
            $user->role = $group;
            $user->save();
        }
        Auth::login($user, $remember);


        return $this->redirectTo;
    }


    protected function checkGroup(\Adldap\Models\Model $user)
    {

        foreach (config('ldap.group') as $key => $group) {
            if ($user->inGroup($group, $recursive = true)) return $key;
        }
        return false;
    }
}
