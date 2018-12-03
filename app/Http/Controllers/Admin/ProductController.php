<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function product_list(){
        return view('admin.product.product_list');
    }
    public function product_brand(){
        return view('admin.product.product_brand');
    }
    public function product_add(){
        return view('admin.product.product_add');
    }
    public function product_category(){
        return view('admin.product.product_category');
    }
    public function product_category_add(){
        return view('admin.product.product_category_add');
    }
}
