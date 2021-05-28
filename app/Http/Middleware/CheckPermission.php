<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Role;

class CheckPermission
{
    /**
    Lệnh tạo php artisan make:middleware CheckPermission
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        // Lấy tất cả các quyền khi User login
        // I. Lấy tất cả các Role của User và hệ thống
        $listRoleOfUser = User::find(auth()->id())->roles()->select('roles.id')->pluck('id')->toArray();

//        $listRoleOfUser = DB::table('users')
//            ->join('role_user', 'users.id', '=', 'role_user.user_id')
//            //join('bảng trung gian', 'bảng gốc.id bảng gốc', '=', 'bảng trung gian.id bảng trung gian')
//            ->join('roles', 'role_user.role_id', '=', 'roles.id')
//            //join('bảng chính', 'bảng trung gian.id bảng trung gian', '=', 'bảng chính.id bảng chính')
//            ->where('users.id', auth()->id())
//            ->select('roles.*')
//            ->get()->pluck('id')->toArray();
        /*
         1. Từ bảng user, lấy id của user đã login vào hệ thống, where('users.id', auth()->id())
         2. Sau đó join sang bảng trung gian, join('role_user', 'users.id', '=', 'role_user.user_id')
         3. Sau đó join sang bảng chính, join('roles', 'role_user.role_id', '=', 'roles.id')
         4. Select toàn bộ Role có của User
         5. Get ra toàn bộ Role
         6. Dùng pluck để lấy ra id  của Role đó
         * */
        // II. Lấy ra tất cả các quyền khi User login vào hệ thống
        $listPermissionOfUser = DB::table('roles')
            ->join('role_permission', 'roles.id', '=', 'role_permission.role_id')
            //join('bảng trung gian', 'bảng gốc.id bảng gốc', '=', 'bảng trung gian.id bảng trung gian')
            ->join('permissions', 'role_permission.permission_id', '=', 'permissions.id')
            //join('bảng chính', 'bảng trung gian.id bảng trung gian', '=', 'bảng chính.id bảng chính')
            ->whereIn('roles.id', $listRoleOfUser) // lấy những roles thuộc $listRoleOfUser, lấy ra permission là 1 mảng nên phải dùng whereIn
            ->select('permissions.*') // lấy cái gì thì select cái đó
            ->get()->pluck('id')->unique(); // unique để gộp 2 bản ghi trùng nhau lại với nhau
//         Lấy ra name (permission) của trang hiện tại (mình định nghĩa ở phần middleware:list-user)
        $checkPermission = Permission::where('name', '=', $permission)->value('id');
//    dd($checkPermission);
        // III. Kiểm tra xem User có được phép vào trang này hay không
        if ($listPermissionOfUser->contains($checkPermission)){
            return $next($request);
        } else {
            return abort(404);
        }


    }
}
