<?php

    namespace App\Admin\Model;

    use Illuminate\Database\Eloquent\Model;

    class AdminMenuModel extends Model {
        //
        protected $table = 'admin_menu';
        protected $fillable = [
            'menu_name',
            'menu_path',
            'menu_controller',
            'description'
        ];

        //当前菜单属于哪个权限
        public function permissions() {
            return $this->belongsToMany(AdminPermissionModel::class, 'permission_menu', 'menu_id', 'permission_id')->withPivot([
                'menu_id',
                'permission_id'
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


    }
