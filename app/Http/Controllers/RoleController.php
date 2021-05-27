<?php

namespace App\Http\Controllers;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use DB;
use Log;

class RoleController extends Controller
{

    private $role;
    private $permission;
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index()
    {
        $listRole = $this->role->all();
        return view('role.index', compact('listRole'));
    }


    public function create()
    {
        $listPermission = $this->permission->all();
        return view('role.add', compact('listPermission'));
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $roleCreate = $this->role->create([
                'name' => $request->name,
                'display_name' => $request->display_name,
            ]);
            $roleCreate->permissions()->attach($request->permissions);
            DB::commit();
            return redirect()->route('role.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Lỗi: ' .$exception->getMessage() .$exception->getLine());
        }
    }

    public function edit($id)
    {
        $listPermission = $this->permission->all();
        $role = $this->role->findOrFail($id);
        $listPermissionOfRole = DB::table('role_permission')->where('role_id', $id)->pluck('permission_id');
        // Tìm đến bảng role_permission, lấy ra $role_id tương ứng với $id bạn vừa truyền lên, dùng pluck để lấy ra $permission_id
        // Dùng get thôi thì lấy full
        // https://laravel.com/docs/8.x/collections#method-pluck
        return view('role.edit', compact('listPermission','role', 'listPermissionOfRole'));
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            // Update role table
            $roleUpdate = $this->role->where('id', $id)->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
            ]);
            // Update to role_permission table
            DB::table('role_permission')->where('role_id', $id)->delete();
            // Xóa những gì có trước đấy trong bảng role_permission
            $roleUpdate = $this->role->find($id);
            // Tìm id của user cần sửa
            $roleUpdate->permissions()->attach($request->permissions);
            DB::commit();
            return redirect()->route('role.index');
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            // Xóa Role
            $role = $this->role->find($id);
            $role->delete($id);
            // Xóa Role ở bảng trung gian
            $role->permissions()->detach();
            DB::commit();
            return redirect()->route('role.index');
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
