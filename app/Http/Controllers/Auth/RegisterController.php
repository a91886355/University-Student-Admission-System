<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Mail;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
        //$this->guard = $guard;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if(isset($data['roleOfficer'])){
            /**User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['roleOfficer'],
            ]);*/

            DB::insert('insert into users (name, email, email_verified_at, password, role) values (?, ?, ?, ?, ?)',
             [$data['name'], $data['email'], now()->toDateTimeString(), Hash::make($data['password']), 'officer']);

            $data = [
                'subject' => "XXX University: Your account of University Student Admission System is assigned.",
                'email' => $data['email'],
                'content' => "Dear {$data['name']},<br>
                <br>
                Your Officer account is arranged. Let's try to login!<br>
                <br>
                Details of New Account:<br>
                Role: Officer<br>
                Email: {$data['email']}<br>
                Password: {$data['password']}<br>
                <br>
                Best,
                <br>
                University Admin
                
                <br><br>
                <a href='http://localhost:8000/login'>>>>>Let's Try To Login<<<<<</a>"
            ];
    
            //dd($data);
    
            Mail::send('noticeEmail-template', $data, function($message) use ($data) {
                $message->to($data['email'])
                ->subject($data['subject']);
            });

            return redirect()->to('/userManage');
        }else{

            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return $this->registered($request, $user)
           // ?: redirect($this->redirectPath());
          ?: redirect()->to('/userManage')->with('success', 'Officer Account are successfully Registered!');
    }

}