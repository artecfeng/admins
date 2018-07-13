<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateAdminMenuTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create('admin_menu', function (Blueprint $table) {
                $table->increments('id');
                //菜单名称
                $table->string('menu_name', 60);
                //菜单介绍
                $table->string('description', 255);
                $table->string('menu_path');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists('admin_menu');
        }
    }
