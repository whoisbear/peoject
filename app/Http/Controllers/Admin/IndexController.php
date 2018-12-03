<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller{
    public function welcome(){
        //dd(auth()->guard('admin')->user()->username);
        return view('admin.welcome');
    }
    
    public function index(){
        return view('admin.index.index');
    }
}
