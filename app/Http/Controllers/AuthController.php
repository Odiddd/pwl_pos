<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index(): View|RedirectResponse
    {
        /**
         * save user data
         */
        $user = Auth::user();

        /**
         * only check user level when user data available
         */
        if ($user) {
            switch ($user->level_id) {
                case '1':
                    return redirect()->intended('admin');
                case '2':
                    return redirect()->intended('manager');
            }
        }
        return view('login');
    }

    /**
     * action process from form log in
     */
    public function proses_login(Request $request): RedirectResponse
    {
        /**
         * in login process, username and password must be filled
         */
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        /**
         * Take only username and password from user data request
         */
        $credential = $request->only('username', 'password');

        /**
         * if user data isn't valid
         */
        if (!Auth::attempt($credential)) {
            return redirect('login')
                ->withInput()
                ->withErrors(['login_gagal' => 'Pastikan kembali username dan password yang dimasukan sudah benar']);
        }

        /**
         * save user data that success log in
         */
        $user = Auth::user();

        return redirect()->intended(match ($user->level_id) {
            /**
             * if user has admin roles
             */
            1 => 'admin',
            /**
             * if user has manager roles
             */
            2 => 'manager',
            /**
             * if user has no roles
             */
            default => '/',
        });
    }

    /**
     * show register view
     */
    public function register(): View
    {
        return view('register');
    }

    /**
     * action process register form
     */
    public function proses_register(Request $request): RedirectResponse
    {
        /**
         * make new object validator for register form
         *
         * nama and password must be fill, and username must unique in our existing username database
         */
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'username' => 'required|unique:m_user',
            'password' => 'required',
        ]);

        /**
         * if validate fails, return error from object Validator class
         */
        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }

        /**
         * if register data validated, fill user roles and hashing password
         */
        $request['level_id'] = '2';
        $request['password'] = Hash::make($request->password);

        /**
         * create user data in database from register form data
         */
        UserModel::create($request->all());
        return redirect()->route('login');
    }

    /**
     * User Logout logic
     */
    public function logout(Request $request): RedirectResponse
    {
        /**
         * logout must flush existing session
         */
        $request->session()->flush();

        /**
         * must run logout function in Auth class
         */
        Auth::logout();
        return redirect('login');
    }
}