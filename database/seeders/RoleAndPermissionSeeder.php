<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo vai trò
        $admin = Role::create(['name' => 'Admin']);
        $staff = Role::create(['name' => 'Staff']);

        // Gán vai trò
        User::find(1)->assignRole('Admin');

        $view_user = Permission::create(['name' => 'Xem danh sách tài khoản']);
        $create_user = Permission::create(['name' => 'Thêm tài khoản']);
        $edit_user = Permission::create(['name' => 'Chỉnh sửa tài khoản']);
        $delete_user = Permission::create(['name' => 'Xóa tài khoản']);

        $admin->givePermissionTo($view_user);
        $admin->givePermissionTo($create_user);
        $admin->givePermissionTo($edit_user);
        $admin->givePermissionTo($delete_user);


        $view_salary = Permission::create(['name' => 'Xem danh sách lương']);
        $create_salary = Permission::create(['name' => 'Thêm lương']);
        $edit_salary = Permission::create(['name' => 'Chỉnh sửa lương']);
        $delete_salary = Permission::create(['name' => 'Xóa lương']);
        $import_salary = Permission::create(['name' => 'Nhập lương excel']);
        $export_salary = Permission::create(['name' => 'Lấy file mẫu']);

        $admin->givePermissionTo($view_salary);
        $staff->givePermissionTo($view_salary);
        $admin->givePermissionTo($create_salary);
        $admin->givePermissionTo($edit_salary);
        $admin->givePermissionTo($delete_salary);
        $admin->givePermissionTo($import_salary);
        $admin->givePermissionTo($export_salary);
        
    }
}
