@extends('admin.layout.index')
@section('content')

 <?php

    function showMenu($data, $tag = "--|", $id = 0, $repairs = 1)
    {
        $repairs++;
        foreach ($data as $value) {
            if ($value['parent'] == $id) {
                echo '<option value="' . $value['id'] . '"> ' . $tag . ' ' . $value['name'] . ' </option>';
                showMenu($data, str_repeat($tag, $repairs), $value['id']);
            }
        }
    }
    $id = '';
    $name = '';
    $unit_price = '';
    $promotion_price = '';
    $unit = '';
    $new = '';
    $description = '';
    $image = '';
    $btnSubmit = 'Thêm sản phẩm';
    if (!empty($product)) {
        $id = $product['id'];
        $name = $product['name'];
        $unit_price = $product['unit_price'];
        $promotion_price = $product['promotion_price'];
        $unit = $product['unit'];
        $new = $product['new'];
        $description = $product['description'];
        $image = $product['image'];
        $btnSubmit = 'Sửa sản phẩm';
    }

    ?>
    
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
             @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

            @if(Session::has('message'))
                    <div class="alert alert-success">
                        {!! Session::get('message') !!}
                    </div>
                @endif

                @if(Session::has('thongbao'))
                    <div class="alert alert-success">
                        {!! Session::get('thongbao') !!}
                    </div>
                @endif
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{!! $btnSubmit !!}
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-12" style="padding-bottom:120px">
                   
                    <form action="{!! route('postAddProduct') !!}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="id" value="{!! $id !!}"
                                   placeholder=""/>
                        </div>
                        <div class="form-group">
                            <label>* Tên sản phẩm</label>
                            <input type="text" class="form-control" name="name" value="{!! $name !!}"
                                   placeholder="Nhập tên sản phẩm"/>
                        </div>
                        <div class="form-group">
                            <label>* Giá sản phẩm</label>
                            <input type="number" class="form-control" name="unit_price" value="{!! $unit_price !!}"
                                   placeholder="Nhập giá sản phẩm"/>
                        </div>
                        <div class="form-group">
                            <label>Giá ưu đãi</label>
                            <input type="number" class="form-control" name="promotion_price"
                                   value="{!! $promotion_price !!}"
                                   placeholder="Nhập giá ưu đãi"/>
                        </div>

                        <div class="form-group">
                            <label>Danh mục</label>
                            @if(!isset($category))
                                <select class="form-control" name="id_type">
                                    <option value="0">Vui lòng chọn danh mục</option>
                                </select>
                            @else
                                <select class="form-control" name="id_type">
                                    @foreach($category as $v)
                                        @if(isset($product['id_type']) && $product['id_type'] == $v['id'])
                                            <option value="{!! $v['id'] !!}" selected="">{!! $v['name'] !!}</option>
                                        @else
                                        
                                            <option value="{!! $v['id'] !!}">{!! $v['name'] !!}</option>
                                        @endif
                                            
                                       
                                    @endforeach


                                </select>
                            @endif
                        </div>

                
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea class="form-control ckeditor" rows="6" name="description"
                                      id="ckeditor">{!! $description !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Unit</label>
                           <select name="unit" id="">
                            @if(!empty($unit))
                            `  @if($unit == "hộp")
                                   <option value="hộp" selected="">Hộp</option>
                                   <option value="gói">Gói</option>
                                   <option value="cái">Cái</option>
                               @elseif($unit == "gói")
                                   <option value="hộp" >Hộp</option>
                                   <option value="gói" selected="">Gói</option>
                                   <option value="cái">Cái</option>
                                @elseif($unit == "cái")
                                    <option value="hộp" >Hộp</option>
                                   <option value="gói" >Gói</option>
                                   <option value="cái" selected="">Cái</option>
                               @endif
                            @else
                                <option value="hộp" >Hộp</option>
                                <option value="gói">Gói</option>
                                <option value="cái">Cái</option>
                            @endif
                           </select>
                        </div>

                         <div class="form-group">
                            <label>New</label>
                            @if($new == 1)
                            <input type="checkbox" name="new" checked="">
                            @else
                             <input type="checkbox" name="new">
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Ảnh sản phẩm</label>
                            <input type="file" name="image" multiple="true">
                            @if(!empty($image))
                            <img src="{!! asset('source/image/product') . '/' . $image !!}" alt="" width="50"
                                         height="50">
                            @endif
                        </div>

                        



                        <button type="submit" class="btn btn-default">{!! $btnSubmit !!}</button>
                        <button type="reset" class="btn btn-default">Đặt lại</button>
                        <form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection