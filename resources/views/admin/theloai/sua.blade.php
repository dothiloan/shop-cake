
@extends('admin.layout.index')
@section('content')

<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Thể loại
                            <small>{{$theloai->name}}</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                             @if(count($errors)>0)
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $err)
                                        {{$err}}<br>
                                    @endforeach
                                </div>
                                @endif

                                 @if(session('thongbao'))
                                <div class="alert alert-success">
                                        {{session('thongbao')}}
                                </div>
                                @endif    
                        <form action="" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <div class="form-group">
                                <label>Tên thể loại</label>
                                <input class="form-control" name="name" placeholder="Điền tên thể loại" value="{{$theloai->name}}" />

                                <input  style= "margin-top:8px "class="form-control" name="description" placeholder="Mô tả" value="{{$theloai->description}}" />

                                <div class="form-group">
                                    <label>Hình ảnh</label>
                                    <input type="file" name="image" class="control-form">
                                    <img src="source/image/product/{{$tl->image}}" alt="" width="95px" height="95px"></td>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-default">Sửa</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
@endsection 
