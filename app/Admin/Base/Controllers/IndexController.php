<?php

    namespace App\Admin\Base\Controllers;

    use App\Admin\Model\AdminPermissionModel;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class IndexController extends Controller {
        //
        public function index() {
            $permissions = AdminPermissionModel::with('menus')->get();

            $viewPermissions=[];
            $users = Auth::guard('admin')->user();
            //2、路由权限限制
            foreach ($permissions as $permission) {
                if ($users->hasPermission($permission)) {
                    $viewPermissions[] = $permission;
                }
            }
            return view('admin/base/index',compact('viewPermissions'));
        }
    }
