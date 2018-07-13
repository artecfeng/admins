<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class AlertAdminMenuTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            //
            Schema::table('admin_menu', function (Blueprint $table) {
                $table->string('menu_controller');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            //
        }
    }
