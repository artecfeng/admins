<?php

    namespace App\Admin\Base\Controllers;

    use App\Admin\Model\AdminRoleModel;
    use App\Admin\Model\AdminUserModel;
    use Illuminate\Http\Request;

    class ManagerController extends Controller {
        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * 管理人员页面
         */
        public function managers(Request $request) {
            //$managers =
            $managers = AdminUserModel::with('roles')->orderBy('created_at', 'desc')->paginate(10);
            return view('admin/base/managers/managers', compact('managers'));
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * 添加管理员
         */
        public function add(Request $request) {
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'username' => 'required|min:2|unique:admin_users,username',
                    'password' => 'required|min:2|max:16|confirmed'
                ]);
                $user = [
                    'username' => $request->post('username'),
                    'password' => bcrypt($request->post('password'))
                ];
                AdminUserModel::create($user);
                return back()->withErrors('新增用户成功！');
            }
            return view('admin/base/managers/add');
        }

        /**
         * @param AdminUserModel $manager
         * @param Request $request
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
         * 编辑
         */
        public function edit(AdminUserModel $manager, Request $request) {
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'username' => 'required|min:2|unique:admin_users,username',
                    'password' => 'required|min:2|max:16|confirmed'
                ]);

                $manager->username = $request->post('username');
                $manager->password = bcrypt($request->post('password'));
                $manager->save();
                return back()->withErrors('修改成功！');
            }
            return view('admin/base/managers/edit', compact('manager'));
        }

        /**
         * @param AdminUserModel $manager
         * 用户角色页面，和储存用户角色
         */
        public function role(AdminUserModel $manager, Request $request) {
            //当前用户的角色
            $myRoles = $manager->roles;
            if ($request->isMethod('get')) {
                //所有角色
                $roles = AdminRoleModel::all();
                return view('admin/base/managers/role', compact('roles', 'myRoles', 'manager'));
            }

            $this->validate($request, [
                'roles' => 'array'
            ]);

            //获取传来的角色
            //$getRoles = $request
            $roles = AdminRoleModel::findMany($request->post('roles'));
            //要增加的角色
            $addRoles = $roles->diff($myRoles);
            foreach ($addRoles as $role) {
                //添加关系
                $manager->setRole($role);
            }

            //要删除的
            $deleteRoles = $myRoles->diff($roles);
            foreach ($deleteRoles as $role) {
                //删除关系
                $manager->deleteRole($role);
            }
            return back()->withErrors('角色修改成功！');
        }

        public function delete(AdminUserModel $manager) {

            $myRoles = $manager->roles;
            foreach ($myRoles as $role) {
                $manager->deleteRole($role);
            }

            $msg = "删除用户《{$manager->username}》成功！";
            $manager->delete();
            return back()->withErrors($msg);
        }


    }
