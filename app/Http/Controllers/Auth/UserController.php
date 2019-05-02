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
