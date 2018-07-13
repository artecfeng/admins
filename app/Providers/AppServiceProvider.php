<?php

    namespace App\Providers;

    use App\Admin\Model\AdminPermissionModel;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Support\ServiceProvider;

    class AppServiceProvider extends ServiceProvider {
        /**
         * Bootstrap any application services.
         *
         * @return void
         */
        public function boot() {
            //设置数据库默认长度 191*4
            Schema::defaultStringLength(191);
            //            $user = Auth::user();
            //            $permissions = AdminPermissionModel::all();
            //            foreach ($permissions as $permission) {
            //                if ($user->hasPermission($permission)) {
            //
            //                }
            //            }

            //if()
            //每个页面都会经过此方法
            //注册完前调用
            //        View::composer('font.base',function($view){
            //            $topics = TopicModel::all();
            //            //将所有topics注入到模板中
            //            $view->with('topics',$topics);
            //        });
        }

        /**
         * Register any application services.
         *
         * @return void
         */
        public function register() {
            //
        }
    }
