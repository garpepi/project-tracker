<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function index()
    {
       return view('login.index');
    }

    public function callapiusinglaravelui(Request $request)
    {
        // Inputan yg diambil
        $credentials = $request->only('username', 'password');
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($credentials == true) {
            $response = Http::post('http://usersmanage.adi-internal.com/api/auth/login', [
                'username' => $credentials['username'],
                'password' => $credentials['password'],
            ]);
            $data = json_decode((string) $response->body(), true);
            // dd($data);
            try {
                $data['access_token'] == true;
                session()->put('token', $data);
                session()->push($data['user']['username'], $data['user']['username']);
                Alert::toast('Slamat Datang', 'success');
                return redirect()->intended('/client');
            } catch (\Throwable $th) {
                try {
                    $data['password'] == true;
                    Alert::toast('Username or password salah', 'error');
                    return redirect('login');
                } catch (\Throwable $th) {
                    $data['error'] == true;
                    return redirect('login');
                }
            }
        }
        return redirect('login');
    }
    public function logout()
    {

        if (session()->has('token')) {
            session()->flush();
            Alert::toast('Anda telah logout !!!', 'success');
            return redirect()->route('login');
        } else {
            return response('Unauthorized.', 401);
        }
    }

    public function userProfile()
    {
        return view('auth.profile-login');
    }
}
