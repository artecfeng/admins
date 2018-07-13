<?php

    namespace App\Admin\Base\Controllers;

    use App\Admin\Model\AdminMenuModel;
    use App\Admin\Model\AdminPermissionModel;
    use App\Admin\Model\AdminUserModel;
    use Illuminate\Http\Request;

    class PermissionController extends Controller {
        /**
         * 权限列表页
         */
        public function permissions() {
            $permissions = AdminPermissionModel::orderBy('created_at', 'desc')->paginate(10);
            return view('admin/base/permissions/permissions', compact('permissions'));

        }

        /**
         * 创建权限
         */
        public function add(Request $request) {
            $this->validate($request, [
                'permission_name' => 'required|min:2|unique:admin_permissions,permission_name',
                'description'     => 'required'
            ]);

            AdminPermissionModel::create($request->only([
                'permission_name',
                'description'
            ]));
            return back()->withErrors("添加权限成功！");

        }

        /**
         * 角色权限关系页面
         */
        public function menu(AdminPermissionModel $permission, Request $request) {

            //            //获取当前角色的权限

            $myMenus = $permission->menus;

            // return response()->json($myPermissions);

            if ($request->isMethod('get')) {
                /**
                 * 获取所有权限
                 */
                $menus = AdminMenuModel::orderBy('created_at')->get();
                return view('admin/base/permissions/menu', compact('permission', 'menus', 'myMenus'));
            }

            $this->validate($request, [
                'menus' => 'array'
            ]);
            $reMenus = AdminMenuModel::findMany($request->post('menus'));

            //要添加的
            $addMenus = $reMenus->diff($myMenus);
            foreach ($addMenus as $menu) {
                $permission->setMenu($menu);
            }
            //要删除的
            $delMenu = $myMenus->diff($reMenus);
            foreach ($delMenu as $menu) {
                $permission->deleteMenu($menu);
            }
            return back()->withErrors("修改权限菜单成功");
        }

        public function delete(AdminPermissionModel $permission) {
            $msg = "删除《{$permission->permission_name}》成功！";
            $myMenus = $permission->menus;
            foreach ($myMenus as $menu) {
                $permission->deleteMenu($menu);
            }
            $myRoles = $permission->roles;
            foreach ($myRoles as $role){
                $permission->deleteRole($role);
            }
            $permission->delete();
            return back()->withErrors($msg);
        }


    }
