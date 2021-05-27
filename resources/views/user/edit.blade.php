    @extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="row">
                <form class="col-md-8" method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <label>Tên</label>
                        <input type="text" class="form-control" value="{{$user->name}}" name="name">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="{{$user->email}}" name="email">
                    </div>

                    <div class="form-group">
                        <label>Quyền</label>
                        <select multiple class="form-control" name="roles[]">
                            @foreach($listRole as $role)
                                <option
                                   {{$listRoleOfUser->contains($role->id) ? 'selected' : ''}}
                            {{--Nếu id nào của role trùng với $listRoleOfUser thì trả về selected, else thì rỗng--}}
                            {{--https://laravel.com/docs/8.x/collections#method-contains--}}
                                    value="{{$role->id}}">{{$role->display_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Sửa</button>
                </form>
         </div>
        </div>
    @endsection



