<?php

    namespace App\Admin\Base\Controllers;

    use App\Admin\Model\AdminPermissionModel;
    use App\Admin\Model\AdminRoleModel;
    use App\Admin\Model\AdminUserModel;
    use Illuminate\Http\Request;

    class RolesController extends Controller {
        /**
         * 角色列表
         */
        public function roles() {
            $roles = AdminRoleModel::orderBy('created_at', 'desc')->with('permissions')->paginate(10);
            return view('admin/base/roles/roles', compact('roles'));
        }

        /**
         * 创建角色
         */
        public function add(Request $request) {
            $this->validate($request, [
                'role_name'   => 'required|min:2|unique:admin_roles,role_name',
                'description' => 'required'
            ]);
            AdminRoleModel::create($request->only([
                'role_name',
                'description'
            ]));
            return back()->withErrors("添加角色成功！");
        }

        /**
         * 角色权限关系页面
         */
        public function permission(AdminRoleModel $role, Request $request) {

            //            //获取当前角色的权限

            $myPermissions = $role->permissions;

            // return response()->json($myPermissions);

            if ($request->isMethod('get')) {
                /**
                 * 获取所有权限
                 */
                $permissions = AdminPermissionModel::all();
                return view('admin/base/roles/permission', compact('role', 'permissions', 'myPermissions'));
            }

            $this->validate($request, [
                'permissions' => 'array'
            ]);
            $rePermissions = AdminPermissionModel::findMany($request->post('permissions'));

            //要添加的
            $addPermission = $rePermissions->diff($myPermissions);
            foreach ($addPermission as $permission) {
                $role->setPermission($permission);
            }
            //要删除的
            $delPermission = $myPermissions->diff($rePermissions);
            foreach ($delPermission as $permission) {
                $role->deletePermission($permission);
            }
            return back()->withErrors("修改角色权限成功");
        }

        public function delete(AdminRoleModel $role) {
            //删除用户关系
            $myManagers = $role->managers;
            foreach ($myManagers as $manager) {
                $role->deleteUser($manager);
            }
            //删除权限关系
            $myPermissions = $role->permissions;
            foreach ($myPermissions as $permission) {
                $role->deletePermission($permission);
            }
            $msg = "删除角色《$role->role_name》成功！";
            $role->delete();
            return back()->withErrors($msg);
        }

    }
