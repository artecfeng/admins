<?php

    namespace App\Admin\Model;

    //use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User;

    class AdminUserModel extends User {
        //
        // use Notifiable;
        protected $table = 'admin_users';
        protected $rememberTokenName = '';

        protected $fillable = [
            'username',
            'password'
        ];

        //用户有哪些角色
        public function roles() {
            //多对多 第二个参数是关系表,地三个参数当前对象在关系表中的外键，第四个参数是对象表在关系表中的外键，获取关系表的字段
            return $this->belongsToMany(AdminRoleModel::class, 'admin_roles_user', 'user_id', 'role_id')->withPivot([
                'user_id',
                'role_id'
            ]);
        }

        //判断是否有某些角色,当前对象是否在某些角色中
        public function isInRoles($roles) {
            //如果是0 返回false，否则返回true
            return !!$roles->intersect($this->roles)->count();
        }

        /**
         * @param $role
         * @return \Illuminate\Database\Eloquent\Model
         * 添加角色
         */
        public function setRole($role) {
            return $this->roles()->save($role);
        }

        /**
         * @param $role
         * 取消用户的角色
         */
        public function deleteRole($role) {
            //删除的是关系，所以用detach
            return $this->roles()->detach($role);
        }

        /**
         * 用户是否有权限
         */
        public function hasPermission($permission) {
            return $this->isInRoles($permission->roles);
        }
    }
