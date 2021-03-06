<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRoleHasUserPermissionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'user_role_has_user_permissions';

    /**
     * Run the migrations.
     * @table user_rol_has_user_permissions
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('id_role');
            $table->unsignedInteger('id_permission');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table($this->set_schema_table, function (Blueprint $table){

            $table->index(["id_role"], 'fk_role_has_permissions_user_roles1_idx');
            $table->index(["id_permission"], 'fk_role_has_permissions_user_permissions1_idx');
            $table->unique(["id_role", "id_permission"], 'user_role_has_user_permissions_unique');

            $table->foreign('id_role', 'fk_role_has_permissions_user_roles1_idx')
                ->references('id')->on('user_roles')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_permission', 'fk_role_has_permissions_user_permissions1_idx')
                ->references('id')->on('user_permissions')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
