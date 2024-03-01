<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
        });

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@app.com',
            'mobile' => '9800000000',
            'password' => Hash::make('123456789'),
            'is_super' => 1,
            'dob' => '2001-04-27',
            'temporary_address' => 'Chardobato, Bhaktapur',
            'permanent_address' => 'Khamariya, Kailali'
        ]);
        
        $user->assignRole('superadmin');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
