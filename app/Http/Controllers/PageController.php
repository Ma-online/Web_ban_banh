<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Slide;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getIndex(){
        $slide = Slide::all();
        $new_product = Product::where('new',1)->Paginate(4);
        $sanpham_khuyenmai = Product::where('promotion_price','<>',0)->Paginate(8);
        //dd($new_product->links());
        
        //return view('Page.trangchu',['slide'=>$slide]);
        return view('Page.trangchu',compact('slide','new_product','sanpham_khuyenmai'));
    }

    public function getLoaiSp($type){

        $sp_theoloai = Product::where('id_type',$type)->get();
        $sp_khac = Product::where('id_type','<>',$type)->paginate(3);
        $loai = ProductType::all();
        $loai_sp = ProductType::where('id',$type)->first();
        return view('Page.loaisanpham',compact('sp_theoloai','sp_khac','loai','loai_sp'));
    }

    public function getChiTietSp(Request $req){
        $sanpham = Product::where('id',$req->id)->first();
        $sp_tuongtu = Product::where('id_type',$sanpham->id_type)->paginate(3);
        return view('Page.chitiet_sanpham',compact('sanpham','sp_tuongtu'));
    }

    public function getLienHe(){
        return view('Page.lienhe');
    }

    public function getGioiThieu(){
        return view('Page.gioithieu');
    }

    public function getAddToCart(Request $req , $id){
        $product = Product::find($id);
        $oldCart = session('cart')?session()->get('cart'):null;
        // dd($oldCart);
        // exit;
        $cart = new Cart($oldCart);
        $cart-> add($product,$id);
        $req -> session()->put('cart',$cart);
        return redirect()->back();
    }

    public function getDelItemCart($id){
        $oldCart = session()->has('cart')?session()->get('cart'):null;
        $cart = new Cart($oldCart);
        $cart -> removeItem($id);
        if(count($cart->items) >0){
            session()->put('cart',$cart);
        }else{
            session()->forget('cart');
        }
        
        return redirect()->back();
    }
}
