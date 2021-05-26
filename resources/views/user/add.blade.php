    @extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="row">
                <form class="col-md-8" method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <label>Tên</label>
                        <input type="text" class="form-control" placeholder="Enter name" name="name">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="Enter email" name="email">
                    </div>

                    <div class="form-group">
                        <label>Mật khẩu</label>
                        <input type="password" class="form-control" placeholder="Enter password" name="password">
                    </div>

                    <div class="form-group">
                        <label>Nhập lại mật khẩu</label>
                        <input type="password" class="form-control" placeholder="Enter confirm password" name="confirm_password">
                    </div>

                    <div class="form-group">
                        <label>Quyền</label>
                        <select multiple class="form-control" name="roles[]">
                            @foreach($listRole as $role)
                                <option value="{{$role->id}}">{{$role->display_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </form>
         </div>
        </div>
    @endsection



