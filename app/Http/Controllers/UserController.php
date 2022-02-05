<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ChangePasswordRequest;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::paginate(10);

        if ($request->search) {
            $users = User::where('name', 'like', '%'.$request->search.'%')->paginate(10);
            $users->appends(['search' => $request->search]);
        }

        $data = [
            'users' => $users
        ];

        return view('user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        
        $data = [
            'roles' => $roles
        ];

        return view('user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $file_path_avatar = '';
            if ($request->file('avatar')) {
                $name_avatar = time().'_'.$request->avatar->getClientOriginalName();
                $file_path_avatar = 'uploads/avatar/user/'.$name_avatar;
                Storage::disk('public_uploads')->putFileAs('avatar/user', $request->avatar, $name_avatar);
            }

            $file_path_cv = '';
            if ($request->file('cv')) {
                $name_cv = time().'_'.$request->cv->getClientOriginalName();
                $file_path_cv = 'uploads/cv/'.$name_cv;
                Storage::disk('public_uploads')->putFileAs('cv', $request->cv, $name_cv);
            }
            
            $create = User::create([
                'code' => '',
                'name' => $request->name,
                'password' => bcrypt($request->password),
                'email' => $request->email,
                'gender' => $request->gender,
                'birthday' => date("Y-m-d", strtotime($request->birthday)),
                'phone' => $request->phone,
                'address' => $request->address,
                'avatar' => $file_path_avatar,
                'cv' => $file_path_cv,
            ]);

            $role = Role::find(2)->name;
            $create->assignRole($role);

            $create->update([
                'code' => 'TK'.str_pad($create->id, 6, '0', STR_PAD_LEFT)
            ]);
            
            DB::commit();
            return redirect()->route('users.index')->with('alert-success','Thêm nhân viên thành công!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','Thêm nhân viên thất bại!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $roles = Role::all();
        
        $data = [
            'user' => $user,
            'roles' => $roles
        ];

        return view('user.profile', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        
        $data = [
            'data_edit' => $user,
            'roles' => $roles
        ];

        return view('user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $file_path_avatar = '';
            if ($request->file('avatar')) {
                $name_avatar = time().'_'.$request->avatar->getClientOriginalName();
                $file_path_avatar = 'uploads/avatar/user/'.$name_avatar;
                Storage::disk('public_uploads')->putFileAs('avatar/user', $request->avatar, $name_avatar);
            }

            $file_path_cv = '';
            if ($request->file('cv')) {
                $name_cv = time().'_'.$request->cv->getClientOriginalName();
                $file_path_cv = 'uploads/cv/'.$name_cv;
                Storage::disk('public_uploads')->putFileAs('cv', $request->cv, $name_cv);
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'birthday' => date("Y-m-d", strtotime($request->birthday)),
                'phone' => $request->phone,
                'address' => $request->address,
                'avatar' => $file_path_avatar,
                'cv' => $file_path_cv,
            ]);



            // if ($request->file('avatar')) {
            //     $name = time().'_'.$request->avatar->getClientOriginalName();
            //     $file_path = 'uploads/avatar/user/'.$name;
            //     Storage::disk('public_uploads')->putFileAs('avatar/user', $request->avatar, $name);
                
            //     $user->update([
            //         'name' => $request->name,
            //         'email' => $request->email,
            //         'gender' => $request->gender,
            //         'birthday' => date("Y-m-d", strtotime($request->birthday)),
            //         'phone' => $request->phone,
            //         'address' => $request->address,
            //         'avatar' => $file_path,
            //     ]);
            // }
            // else {
            //     $user->update([
            //         'name' => $request->name,
            //         'email' => $request->email,
            //         'gender' => $request->gender,
            //         'birthday' => date("Y-m-d", strtotime($request->birthday)),
            //         'phone' => $request->phone,
            //         'address' => $request->address,
            //     ]);
            // }
            
            DB::commit();
            return redirect()->route('users.index')->with('alert-success','Sửa nhân viên thành công!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','Sửa nhân viên thất bại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            if ($user->salaries->count() > 0) {
                return redirect()->back()->with('alert-error','Xóa nhân viên thất bại! Nhân viên '.$user->name.' đang có dữ liệu.');
            }

            $user->roles()->detach();
            $user->destroy($user->id);
            
            DB::commit();
            return redirect()->route('users.index')->with('alert-success','Xóa nhân viên thành công!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','Xóa nhân viên thất bại!');
        }
    }

    public function viewChangePassword(User $user) 
    {
        $data = [
            'user' => $user,
        ];

        return view('user.change-password', $data);
    }

    public function changePassword(ChangePasswordRequest $request, User $user) 
    {
        try {
            DB::beginTransaction();
            
            if (Hash::check($request->password_old, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
            
            DB::commit();
            return redirect()->back()->with('alert-success','Đổi mật khẩu thành công!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','Đổi mật khẩu thất bại!');
        }
    }
}
