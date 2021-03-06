<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Decoration;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    public function getCheckout(){
       return view('Page.dat_hang');
    }

    public function postCheckout(Request $req){
        $cart = session()->get('cart');
        
        $customer = new Customer();
        $customer->name = $req -> name;
        $customer -> gender = $req ->gender ;
        $customer -> email = $req ->email;
        $customer -> address = $req->address;
        $customer -> phone_number = $req -> phone_number;
        $customer -> note = $req-> note;
        $customer -> save();

        $bill = new Bill;
        $bill -> id_customer = $customer ->id;
        $bill ->date_order =  date('Y-m-d');
        $bill ->total = $cart -> totalPrice;
        $bill ->payment = $req -> payment_method;
        $bill->note = $req -> notes;
        $bill ->save();

        foreach($cart->items as $key => $value){
            $bill_detail = new BillDetail;
            $bill_detail -> id_bill = $bill -> id;
            $bill_detail ->id_product = $key;
            $bill_detail ->quantity = $value['qty'];
            $bill_detail -> unit_price = ($value['price']/$value['qty']);
            $bill_detail->save();
        }

        session()->forget('cart');

        return redirect()->back()->with('thongbao','?????t h??ng th??nh c??ng');

        



    }
    public function getLogin(){
        return view('Page.dangnhap');
    }

    public function postLogin(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email|',
                'password'=>'required|min:6|max:20',
            ],
            [
                'email.required'=>'vui l??ng nh???p email',
                'email.email'=>'Kh??ng ????ng ?????nh d???nh email',
                'password.required' => 'Vui l??ng nh???p password',
                'password.min' => 'M???t kh???u ??t nh???t 6 k?? t???'
            ]);
            $credentials = array('email'=> $req->email,'password'=> $req -> password);
            if(Auth::attempt($credentials)){
                return redirect()->back()->with(['flag'=>'success','message'=>'????ng nh???p th??nh c??ng']);

            }else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'????ng nh???p th???t b???i']);
            }

    }

    public function getSignin(){
        return view('Page.dangky');
    }

    public function postSignin(Request $req){
        $this->validate( $req,
            [
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:6|max:20',
                'fullname'=>'required',
                're_password'=>'required|same:password'
            ],
            [
                'email.required'=>'vui l??ng nh???p email',
                'email.email'=>'Kh??ng ????ng ?????nh d???nh email',
                'email.unique' => 'Email ???? c?? ng?????i s??? d???ng',
                'password.required' => 'Vui l??ng nh???p password',
                're_password.same' => 'Password kh??ng gi???ng nhau',
                'password.min' => 'M???t kh???u ??t nh???t 6 k?? t???'
            ]
            );
            $user = new User();
           $user ->full_name = $req->fullname;
           $user -> email = $req -> email;
           $user-> password = Hash::make($req->password);
           $user-> phone = $req ->phone;
           $user -> address = $req ->address;
           $user->save();
           return redirect()->back()->with('thangcong','???? t???o t??i kho???n th??nh c??ng');


    }

    public function getLogout(){
        Auth::logout();
        return redirect()->route('trang-chu');
    }

    public function getSearch(Request $req){
        $product = Product::where('name','like','%'.$req->key.'%')
                          -> orwhere('unit_price',$req->key)
                          -> get();
        return view('Page.search',compact('product'));                
    }

    public function getDecoration($id){
        $loai = Decoration::all();
        $phukien = Decoration::where('id',$id)->first();
      
        return view('Page.phukiensanpham',compact('loai','phukien'));
    }

}
