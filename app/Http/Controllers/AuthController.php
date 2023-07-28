<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('nip', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->withSuccess('You have Successfully loggedin');
        }
        //create token as plaintexttoken
        return redirect('/')->withSuccess('Oppes! You have entered invalid credentials');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        $absensi = Absensi::all();
        $a = $absensi->where('user.deleted_at', null)->groupBy("user.fullname");
        $finalData = [];
        $finalValue = [];


        foreach ($a as $key => $value) {
            array_push($finalData, $key);
            array_push($finalValue, count($value));
        }
        if (Auth::check()) {
            return view('dashboard.index', [
                'label' => $finalData,
                'value' => $finalValue,
            ]);
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }
}
