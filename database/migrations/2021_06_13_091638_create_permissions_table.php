<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name')->unique();
            $table->string('type');
            $table->boolean('primary')->default(0);
            $table->unsignedBigInteger('url_id')->nullable();
            $table->timestamps();

            $table->foreign('url_id')->references('id')->on('u_r_l_s');
        });

        foreach (config('addons.config.permissions') as $type => $permission) {
            foreach ($permission as $value) {
                Permission::create([
                    'name' => $value,
                    'type' => $type,
                    'primary' => 1
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
