<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'user' => 'required|alpha|min:3',
            'email' => 'required|email',
            'password' => 'required',
            'posisi' => 'required|alpha',
            'status' => 'required',
        ]);

        $data = [
            'user' => $request->input('user'), 
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'api_token' => '13579',     // 'api_token' => $request->input('api_token'), 
            'posisi' => 'pelanggan',    // 'posisi' => $request->input('posisi'), 
            'status' => '1',            // 'status' => $request->input('status'), 
            'relasi' => $request->input('email'),
        ];

        User::create($data);

        return response()->json($data);
    }

    public function login(Request $request)
    {
       $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if ($user->password === $password)
        {
            $token = Str::random(40);

            User::where('email', $email)->update([
                'api_token' => $token,
            ]);

            return response()->json([
                'pesan' => 'Login Berhasil',
                'token' => $token,
                'data' => $user,
            ]);
        }
        else
        {
            return response()->json([
                'pesan' => 'Login Gagal',
                'data' => ''
            ]);
        }
    }
}
