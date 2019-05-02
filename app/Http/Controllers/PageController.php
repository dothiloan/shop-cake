<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
use App\Product;
use App\ProductType;
use App\Cart;
use App\Customer;
use App\Bill;
use App\User;
use App\BillDetail;
use Session;
use Hash;
use Auth;

class PageController extends Controller
{
    public function getIndex(){
        $slide=Slide::all();

        $new_product = Product::where('new',1)->paginate(4);
        $sanpham_khuyenmai = Product::where('promotion_price','<>',0)->paginate(8); 

        return view('page.trangchu',compact('slide','new_product','sanpham_khuyenmai'));
    }

     public function getLoaiSp($type){
        $sp_theoloai = Product::where('id_type',$type)->get();
        $sp_khac = Product::where('id_type','<>',$type)->paginate(3);
        $loai    = ProductType::all();
        $loai_sp = ProductType::where('id',$type)->first();
    	return view('page.loai_sanpham',compact('sp_theoloai','sp_khac','loai','loai_sp'));
    }

     public function getChitiet(Request $req){
      $sanpham = Product::where('id',$req->id)->first();
      $sp_tuongtu = Product::where('id_type',$sanpham->id_type)->paginate(6);
    	return view('page.chitiet_sanpham',compact('sanpham','sp_tuongtu'));
    }

     public function getLienHe(){
    	return view('page.lienhe');
    }
     public function getGioiThieu(){
      return view('page.gioithieu');
    }

     public function getAddtoCart(Request $req, $id){
      $product = Product::find($id);
      $oldCart = Session('cart')?Session::get('cart'):null;
      $cart = new Cart($oldCart);
      $cart->add($product, $id);
      $req->session()->put('cart', $cart);
      return redirect()->back();
    }

      public function getDelItemCart($id){
         $oldCart = Session('cart')?Session::get('cart'):null;
         $cart = new Cart($oldCart);
         $cart->removeItem($id);
         // nếu số lượng==0 -> remove session
         if(count($cart->items)>0){
          Session::put('cart', $cart);
         }
         else{
          Session::forget('cart');
         }
         
         return redirect()->back();
     
    }

    public function getCheckout(){
      return view('page.dat_hang');
    }

     public function getpostCheckout(Request $req){
      $cart = Session::get('cart');
      $customer = new Customer;
      $customer->name = $req->name;
      $customer->gender = $req->gender;
      $customer->email = $req->email;
      $customer->address = $req->address;
      $customer->phone_number = $req->phone;
      $customer->note = $req->note;
      // luưu vào database
      // dd($req->all());
      $customer->save();

      $bill = new Bill;
      $bill->id_customer = $customer->id;
      $bill->date_order = date('Y-m-d');
      $bill->total = $cart->totalPrice;
       $bill->payment = $req->payment_method;
       $bill->note = $req->notes;
       // luưu vào database
      $bill->save();

      foreach($cart->items as $key =>$value)
      {
      $bill_detail= new BillDetail;
      $bill_detail->id_bill= $bill->id;
       $bill_detail->id_product= $key;
      $bill_detail->quantity= $value['qty'];
      $bill_detail->unit_price= $value['price']/$value['qty'];
      $bill_detail->save();
    }

    Session::forget('cart');
    return redirect()->back()->with('thongbao','Đặt hàng thành công');
  }

     public function getLogin(){
      return view('page.dangnhap');
    }

       public function getSignin(){
      return view('page.dangki');
    }

       public function postSignin(Request $req)
    {
        $this->validate($req,
          [
            //bắt buộc người dùng nhập 
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20',
            'fullname' => 'required',
            're_password' => 'required|same:password',
          ],
          [
            'email.required'=>'Vui lòng nhập Email',
            'email.email'=>'Không đúng định dạng Email',
            'email.unique'=>'Email đã có người sử dụng',
            'password.required'=>'Vui lòng nhập mật khẩu',
            're_password.same'=>'Mật khẩu không trùng khớp',
            'password.min'=>'mật khẩu ít nhất 4 ký tự',
            ]);
            //tạo biến lưu vào database
            $user = new User;
            $user->full_name = $req->fullname;
            $user->email = $req->email;
            // hàm hash mã hõa 
            $user->password = Hash::make($req->password);
            $user->email = $req->email;
            $user->phone = $req->phone;
            $user->address = $req->address;
            $user->save();
            return redirect()->back()->with('thanhcong','tạo tài khoản thành công');
    }
            //Sử lý đăng nhâp
     public function postLogin(Request $req){
       // kiểm tra khi người dùng nhập mới cho login
        $this->validate($req,
        [
            "email" => "required",
            "password" => "required|min:3|max:32",
        ],[
            "email.required" => "Bạn chưa nhập tên.",
            "password.required" => "Bạn chưa nhập mật khẩu.",
            "password.min" => "Password không đươc nhập ít hơn 3 ký tự.",
            "password.max" => "Mật khẩu không được nhập tối đa 32 ký tự."
        ]);
        //Lấy thông tin và so sánh với data
        $credentials = array('email'=>$req->email,'password'=>$req->password);
        if (Auth::attempt($credentials)) {
            return redirect()->back()->with(['flag'=>'success','message'=>'Đăng nhập thành công']);
        }
        else{
            return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập không thành công']);
        }
    }

    public function getLogout1()
    {
       return redirect()->route('trang-chu');
    }
    public function getSearch(Request $req){
        $product = Product::where('name','like','%'.$req->key.'%')
                            ->orWhere('unit_price',$req->key)
                            ->get();
        return view('page.search',compact('product'));
    }


      public function getAdmin(){
      return view('admin.theloai.danhsach');
    }


    //Controller admin

      public function getDanhSach(){
        $theloai = ProductType::all();
      return view('admin.theloai.danhsach',['theloai'=>$theloai]);
    } 

      public function getThem(){
        $theloai = ProductType::all();
      return view('admin.theloai.them',compact('theloai'));
    } 
      // truyền Request để nhận data
      public function postThem(Request $request){
        // truyền mảng 2 tham số ,1 là lỗi, 2 là thông báo 
        // echo $request->description;
      $this->validate($request,
        [   
          'name'=>'required|min:3|max:100|unique:type_products,name'
        ],
        [
          'name.required'=>'Bạn chưa nhập tên thể loại',
          'image.required'=>'Bạn chưa chọn ảnh',

          'name.min'=>'Tên thể loại phải có độ dài từ 3 cho đến 100 kí tự',
          'name.max'=>'Tên thể loại phải có độ dài từ 3 cho đến 100 kí tự',
          'name.unique'=>'Tên thể loại đã tồn tai'
        ]);

      // Lưu tên vào model
      $theloai = new ProductType;
      $theloai->name = $request->name;
      $theloai->description = $request->description;
      $theloai->image = $request->image;
      // $sanpham_admin->created_at = $request->created_at;
      // $sanpham_admin->updated_at = $request->updated_at;
      $theloai->save();
      return redirect('admin/theloai/them')->with('thongbao','Thêm thành công');
    } 

      public function getSua($id){

        $theloai = ProductType::find($id);

      return view('admin.theloai.sua',compact('theloai'));
    } 
      public function postSua(Request $request, $id){

      $theloai = ProductType::find($id);

      // Kiểm tra biến sửa
      $this->validate($request,
        [
           'name'=>'required|unique:type_products,name|min:3|max:100'
        ],
        [
          'name.required'=>'Bạn chưa nhập tên thể loại',
          'name.unique'=>'Tên thể loại đã tồn tai',
          'name.min'=>'Tên thể loại phải có độ dài từ 3 cho đến 100 kí tự',
          'name.max'=>'Tên thể loại phải có độ dài từ 3 cho đến 100 kí tự',
        ]);

       $theloai->name = $request->name;
       $theloai->description = $request->description;
       $theloai->image = $request->image;
        $theloai->save();
        return redirect('admin/theloai/danhsach')->with('thongbao','Sửa thành công');
    }
    function getXoa($id){
        $theloai = ProductType::find($id);
        $theloai->delete($id);
        return redirect('admin/theloai/danhsach')->with('thongbao','Xóa thành công');

    }

    function getLogout(){
        
        //Do Sthing  
      return redirect('admin/dangnhap');
          
     }
}



