@extends('admin.layout.index')
@section('content')

   
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                @if(Session::has('message'))
                    <div class="alert alert-success">
                        {!! Session::get('message') !!}
                    </div>
                @endif
                <div class="col-lg-12">

                    <h1 class="page-header">Danh sách sản phẩm
                        <small></small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->

                
            </div>
            <!-- /.row -->

            <div class="row">
             
            @foreach($products as $value)
              <div class="col-sm-2 col-md-2">
                <div class="thumbnail">
                  <img src="{!! asset('source/image/product') . '/' . $value['image'] !!}"  height="100px" >
                  <div class="caption">
                    <h5>{!! $value['name'] !!}</h5>
                    <p>{!! number_format($value['unit_price']) . 'đ' !!}</p>
                    <p><a href="{!! route('addProduct') . '/' . $value['id'] !!}" class="btn btn-primary" role="button">Sửa</a> <a href="{!! route('delete-product') . '/' . $value['id'] !!}" class="btn btn-default" role="button">Xóa</a></p>
                  </div>
                </div>
              </div>
            @endforeach
            
            </div>

            <div class="row">
                <div class="text-center">
                {!! $products->links(); !!}
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection