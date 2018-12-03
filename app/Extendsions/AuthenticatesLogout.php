<?php
namespace App\Extendsions;

use Illuminate\Http\Request;


trait AuthenticatesLogout
{
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->forget($this->guard()->getName());

        $request->session()->regenerate();
        
        return $request->path() == 'logout' ? redirect('/') : redirect('/admin/login');
    }
}