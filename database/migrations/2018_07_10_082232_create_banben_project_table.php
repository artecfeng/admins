<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateBanbenProjectTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create('banben_project', function (Blueprint $table) {
                $table->increments('id');
                //用户id
                $table->integer('uid')->default(1);
                //项目名称
                $table->string('name', 200)->default('');
                //项目概述
                $table->string('info', 255)->default('');
                //项目路径
                $table->string('paths', 255)->default('');
                //库名称
                $table->string('ku', 30)->default('');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists('banben_project');
        }
    }
