<?php

namespace App\Http\Controllers\v1\web;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $request;
    function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function login(){
        if(auth()->check()){
            return redirect(route('date-view'));
        }
        return view('pages.login');
    }

    public function authenticate(){
        try{
            $this->validate($this->request,[
                'username' => 'required|string',
                'password' => 'required|string'
            ]);
            $remember = false;
            if ($this->request->has('remember')) {
                $remember = true;
            }
            if(auth()->attempt($this->request->only(['username','password'],$remember))){
                return redirect('/v1/admin/location');
            }
            return view('pages.login',['error_msg' => 'Incorrect Credentials']);
        }
        catch(Exception $ex){
            dd($ex);
        }
    }

    public function logout(){
        try{
            session()->flush();
            auth()->logout();
            $response = new RedirectResponse(route('web.login')); // Replace '/' with your desired redirect URL
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
             ->header('Pragma', 'no-cache')
             ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
            return $response;
        }
        catch(Exception $ex){
            dd($ex);
        }
    }
}
