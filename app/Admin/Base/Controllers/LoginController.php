<?php

    namespace App\Admin\Base\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class LoginController extends Controller {
        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * 登录页面
         */
        public function login(Request $request) {
            //如果是post请求，则是登录操作

            if ($request->isMethod('get')) {

                return view('admin/base/login');
            }
            //校验
            $this->validate($request, [
                'username' => 'required|min:2',
                'password' => 'required'
            ]);

            //逻辑
            if(Auth::guard('admin')->attempt($request->only(['username','password']))){
                return redirect('admin');
            }

                return back()->withErrors('用户名和密码不匹配');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * 推出登录
         */
        public function logout() {
            Auth::guard('admin')->logout();
            return redirect('admin/login');
        }


    }
