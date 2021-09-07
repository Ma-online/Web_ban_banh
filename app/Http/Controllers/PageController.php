<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getIndex(){
        return view('Page.trangchu');
    }

    public function getLoaiSp(){
        return view('Page.loaisanpham');
    }
}
