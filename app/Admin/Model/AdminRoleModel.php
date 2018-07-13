<?php

    namespace App\Admin\Model;

    use Illuminate\Database\Eloquent\Model;

    class AdminRoleModel extends Model {
        //
        protected $table = 'admin_roles';
        protected $fillable = [
            'role_name',
            'description'
        ];

        //当前角色的所有权限
        public function permissions() {
            return $this->belongsToMany(AdminPermissionModel::class, 'admin_roles_permission', 'role_id', 'permission_id')->withPivot([
                'role_id',
                'permission_id'
            ]);
        }

        public function managers() {
            return $this->belongsToMany(AdminUserModel::class, 'admin_roles_user', 'role_id', 'user_id')->withPivot([
                'role_id',
                'user_id'
            ]);
        }

        /**
         * @param $permission
         * 给角色权限
         */
        public function setPermission($permission) {
            return $this->permissions()->save($permission);
        }

        /**
         * @param $permisson
         * @return int
         * 删除角色的权限
         */
        public function deletePermission($permisson) {
            return $this->permissions()->detach($permisson);
        }

        /**
         * @param $permission
         * @return mixed
         * 判断集合内是否有某个对象
         */
        public function hasPermission($permission) {
            return $this->permissions->contains($permission);
        }

        public function deleteUser($manager) {
            return $this->managers()->detach($manager);
        }

    }
