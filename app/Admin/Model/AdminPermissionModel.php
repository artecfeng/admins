<?php

    namespace App\Admin\Model;

    use Illuminate\Database\Eloquent\Model;

    class AdminPermissionModel extends Model {
        //
        protected $table = 'admin_permissions';
        protected $fillable = [
            'permission_name',
            'description'
        ];

        /**
         * 权限属于哪个角色
         */
        public function roles() {
            return $this->belongsToMany(AdminRoleModel::class, 'admin_roles_permission', 'permission_id', 'role_id');
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
         * 当前权限拥有哪些菜单
         */
        public function menus() {
            return $this->belongsToMany(AdminMenuModel::class, 'permission_menu', 'permission_id', 'menu_id');
        }


        /**
         * @param $menu
         * @return Model
         * 为当前权限设置菜单
         */
        public function setMenu($menu) {
            return $this->menus()->save($menu);
        }

        /**
         * @param $menu
         * @return int
         * 为当前权限删除菜单，删除关系，并不真正删除菜单
         */
        public function deleteMenu($menu) {
            return $this->menus()->detach($menu);
        }

        public function deleteRole($role) {
            return $this->roles()->detach($role);
        }

    }
