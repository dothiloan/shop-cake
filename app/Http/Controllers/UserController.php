<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;


class UserController extends Controller
{
    public function getDanhSach(){

        $user = User::all();

        return view('admin.user.danhsach',['user'=>$user]);

    }

     public function getThem(){
       
        return view('admin.user.them');
    }

     public function postThem(Request $request){
        $this->validate($request,[
              'full_name'=>'required|min:3',
              'email'=>'required|email|unique:users,email',
              'password'=> 'required|min:6|max:32',
          ],
          [
              'full_name.required' => 'Bạn chưa nhập tên người dùng',
              'full_name.min' => 'Tên người dùng phải có ít nhất 3 kí tự',
              'email.required' => 'Bạn chưa nhập email',
              'email.email' => 'Bạn chưa nhập đúng định dạng email',
              'email.unique' => 'Email đã tồn tại',
              'password.required' => 'Bạn chưa nhập password',
              'password.min' => ' Password phải có ít nhất 3 kí tự',
              'password.max' => ' Password chỉ được tối đa 32 kí tự',
              'phone.required' => 'Bạn chưa nhập số điện thoại',
               'diachi.required' => 'Bạn chưa nhập địa chỉ',
          ]);
        //Lưu người dùng
        $user =  new User;

        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
       
        $user -> save();

        return redirect('admin/user/them')->with('thongbao','Thêm thành công');
    }

     public function getChitiet(Request $req){
      
    }

    public function getDangnhapAdmin(Request $req){
      return view('admin.login');
    }

      public function postDangnhapAdmin(Request $request){

        
      	// kiểm tra xem email, password có đúng k
      $this->validate($request,[
      'email'=>'required|min:3|max:32'
      ],[
      'email.required'=>'Bạn chưa nhập Email',
      'password.required'=>'Bạn chưa nhập password',
      'password.min' =>'Password không được nhỏ hơn 3 kí tự',
      'password.max' =>'Password không được lớn hơn 32 kí tự',
      ]);

      // dùng attemp để kiểm tra 
      if(Auth::attempt(['email'=>$request->email,'password'=> $request->password]))
      {
      	//nếu đăng nhập thành công thì attempt trả về true và lưu vào database
        // dd(Auth::user());
      	 return redirect('admin/theloai/danhsach');

      }

      else{
      		return redirect('admin/dangnhap')->with('thongbao','Đăng nhập không thành công');

      	
      }
    }
      //Sửa admin user
      public function getSua($id){
        $user  = User::find($id);
        return view('admin.user.sua',compact('user'));
      
    }
}



