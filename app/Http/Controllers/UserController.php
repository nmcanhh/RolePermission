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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
