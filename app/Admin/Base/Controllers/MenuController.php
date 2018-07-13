<?php

    namespace App\Admin\Base\Controllers;

    use App\Admin\Model\AdminMenuModel;
    use App\Admin\Model\AdminPermissionModel;
    use App\Admin\Model\AdminRoleModel;
    use App\Admin\Model\AdminUserModel;
    use Illuminate\Http\Request;

    class MenuController extends Controller {
        /**
         *菜单列表
         */
        public function menus() {
            $menus = AdminMenuModel::orderby('created_at', 'desc')->with('permissions')->paginate(10);
            //$roles = AdminRoleModel::orderBy('created_at', 'desc')->with('permissions')->paginate(10);
            return view('admin/base/menus/menus', compact('menus'));
        }

        /**
         * 创建菜单
         */
        public function add(Request $request) {
            $this->validate($request, [
                'menu_name'   => 'required|min:2|unique:admin_menu,menu_name',
                'menu_path'   => 'required|unique:admin_menu,menu_path',
                //'menu_controller' => 'required|unique:admin_menu,menu_controller',
                'description' => 'required'
            ]);
            AdminMenuModel::create($request->only([
                'menu_name',
                'menu_path',
                'description'
            ]));
            return back()->withErrors("添加菜单成功！");
        }

        public function delete(AdminMenuModel $menu) {
            $myPermissions = $menu->permissions;
            foreach ($myPermissions as $permission) {
                $menu->deletePermission($permission);
            }
            $menu->delete();
            return back()->withErrors("删除《{$menu->menu_name}》成功！");
        }


    }
