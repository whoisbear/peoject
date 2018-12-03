<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertController extends Controller{
    public function advert_list(){
        return view('admin.advert.advert_list');
    }
    public function advert_show(){
        return view('admin.advert.advert_show');
    }
    public function advert_add(){
        return view('admin.advert.advert_add');
    }
}
