<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\ProductType;
use App\Product;
use App\Bill;
use App\User;
use DB;

class AdminController extends Controller
{
      public function addProduct($id = 0) {
      	if($id == 0) {
      		$dataCategory = ProductType::all()->toArray();
      		return view('admin.sanpham.product_add', ['category' => $dataCategory]);
      	}else {
      		if(Product::find($id)){
                $product = Product::where('id', $id)->get()->toArray();
                $dataCategory = ProductType::all()->toArray();
               
                return view('admin.sanpham.product_add', ['product' => $product[0], 'category' => $dataCategory]);
            }
      	}
      	
      }

       public function postAddProduct(ProductRequest $request)
    {

        $data = $request->all();
        //dd($data);
        $name = $data['name'];
        $unit_price = $data['unit_price'];
        $promotion_price = $data['promotion_price'];
        $id_type = $data['id_type'];
        $description = $data['description'];
        $new = (isset($data['new']) && $data['new'] == "on") ? "1" : "0";
        $unit = $data['unit'];
        $nameImage = '';

         if ($request->hasFile('image')) {

                if ($files = $request->file('image')) {
                    
                        $nameImage = time() . $files->getClientOriginalName();
                        $files->move('source/image/product/', $nameImage);
                        
                    
                }
           }

        if(isset($data['id'])) {
         
        	$product = Product::find($data['id']);
        	$product->name = $name;
        	$product->unit_price = $unit_price;
            $product->promotion_price = $promotion_price;
            $product->id_type = $id_type;
            $product->new = $new;
            $product->unit = $unit;
            $product->description = $description;
            if($request->file('image')) {
              $product->image = $nameImage;
            }
            
            $product->save();
            return redirect()->back()->with('message', 'Sửa thành công');

        }else {
	            $product = new Product;
	            $product->name = $name;
	            $product->unit_price = $unit_price;
	            $product->promotion_price = $promotion_price;
	            $product->id_type = $id_type;
	            $product->new = $new;
	            $product->unit = $unit;
	            $product->description = $description;
	            $product->image = $nameImage;
	            $product->save();
            return redirect()->back()->with('thongbao', 'Thêm thành công');
       	 }

        

    }

     public function showProduct(){
        $products = Product::paginate(12);
        $dataCategory = ProductType::all()->toArray();
        
        return view('admin.sanpham.product_list', ['products' => $products, 'categories' => $dataCategory]);
    }

     public function deleteProduct($id){
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('list-product')->with('message', 'Xóa thành công');
    }

    public function dashboard() {
      $type_product = ProductType::all()->toArray();
      $product = Product::all()->toArray();
      $user = User::all()->toArray();
      $bill = Bill::all()->toArray();
      $month = [];
      for($i = 1; $i <= 12; $i++) {
        $month[$i]['detail'] = DB::table('bills')->whereMonth('created_at', $i)->get()->toArray();
      }

      for($i = 1; $i <= 12; $i++) {
        $month[$i]['qty'] = DB::table('bill_detail')->whereMonth('created_at', $i)->get()->toArray();
      }
      //dd($month);
     
      return view('admin.dashboard.dash', ['category' => $type_product, 'product' => $product, 'user' => $user, 'bill' => $bill, 'month' => $month]);
    }
    	
}
