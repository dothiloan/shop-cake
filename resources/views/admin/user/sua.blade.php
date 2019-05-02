 @extends('admin.layout.index')
@section('content')
 <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">User                           
                            <small>{{$user->full_name}}</small>
                            }
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                        <form action="admin/user/sua/{{$user->id}}" method="POST">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">

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

                            <div class="form-group">
                                <label>Họ tên</label>
                                    <input class="form-control" name="full_name" placeholder="Nhập tên người dùng" value="{{$user->full_name}}" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Nhập địa chỉ email" value="{{$user->email}}/>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" />
                            </div>

                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control" name="phone" placeholder="Nhập vào số điện thoại" />
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" name="diachi" placeholder="Nhập vào địa chỉ"/>
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