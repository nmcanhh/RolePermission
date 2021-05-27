<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use DB;


class UserController extends Controller
{
    private $user;
    private $role;
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }


    public function index()
    {
        $listUser = $this->user->all();
        return view('user.index', compact('listUser'));
    }

    public function create()
    {
        $listRole = $this->role->all();
        return view('user.add', compact('listRole'));
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            // Insert data to user table
            $userCreate = $this->user->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password) // Mã hóa password
            ]);
            // Insert data to role_user table
            $userCreate->roles()->attach($request->roles);
            // roles() là phương thức trong model User
            // attach là phương thức dùng để lấy dữ liệu và insert vào bảng trung gian
            // biến roles sau cùng là roles[] nằm ở view lưu id của các roles được chọn ở view
            // $userCreate sẽ lấy được id_user và roles sẽ lấy id_roles
            // cả 2 id này sẽ được eloquent tự động add vào bảng trung gian theo thứ tự alpha B
//            $roles = $request->roles;
//            foreach ($roles as $roleID) {
//                \DB::table('role_user')->insert([
//                    'user_id' => $userCreate->id,
//                    'role_id' => $roleID
//                ]);
//            }
            DB::commit();
            return redirect()->route('user.index');
        } catch (\Exception $exception) {
            DB::rollBack();
        }
        // Đảm bảo khi nào chạy thành công thì mới commit(), không thì nó sẽ rollback() lại.
    }

    public function edit($id)
    {
        $listRole = $this->role->all();
        $user = $this->user->findOrFail($id);
        $listRoleOfUser = DB::table('role_user')->where('user_id', $id)->pluck('role_id');
        // Tìm đến bảng role_user, lấy ra $user_id tương ứng với $id bạn vừa truyền lên, dùng pluck để lấy ra role_id
        // Dùng get thôi thì lấy full
        // https://laravel.com/docs/8.x/collections#method-pluck
        return view('user.edit', compact('listRole','user', 'listRoleOfUser'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            // Update user table
            $userUpdate = $this->user->where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            // Update to role_user table
            DB::table('role_user')->where('user_id', $id)->delete();
            // Xóa những gì có trước đấy trong bảng role_user
            $userUpdate = $this->user->find($id);
            // Tìm id của user cần sửa
            $userUpdate->roles()->attach($request->roles);
            // Insert dữ liệu vào bảng trung gian
            DB::commit();
            return redirect()->route('user.index');
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            // Xóa User
            $user = $this->user->find($id);
            $user->delete($id);
            // Xóa User ở bảng trung gian
            $user->roles()->detach();
            DB::commit();
            return redirect()->route('user.index');
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
