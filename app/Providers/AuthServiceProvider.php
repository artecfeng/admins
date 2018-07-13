<?php

    namespace App\Providers;

    use App\Admin\Model\AdminPermissionModel;
    use App\Admin\Model\AdminUserModel;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\View;

    class AuthServiceProvider extends ServiceProvider {
        /**
         * The policy mappings for the application.
         *
         * @var array
         */
        protected $policies = [
            'App\Model' => 'App\Policies\ModelPolicy',
        ];

        /**
         * Register any authentication / authorization services.
         *
         * @return void
         */
        public function boot() {
            $this->registerPolicies();

            //

            //1、注册gate 对每个permissions定义一个门卫


            $permissions = AdminPermissionModel::all();
            //$viewPermissions = [];
            //$users = Auth::guard('admin')->id();
            //2、路由权限限制
            foreach ($permissions as $permission) {
                //1、门卫的名字
                Gate::define($permission->permission_name, function (AdminUserModel $user) use ($permission, &$bc) {
                    return $user->hasPermission($permission);
                });

                //                if ($users->hasPermission($permission)) {
                //                    $viewPermissions[] = $permission;
                //                }
            }
//            Log::error('view' . $users);
//
//            //3、左边栏目
//            View::composer('admin.leftnav.system', function ($view) use ($viewPermissions) {
//                //将所有topics注入到模板中
//                $view->with('viewPermissions', $viewPermissions);
//            });
        }
    }
