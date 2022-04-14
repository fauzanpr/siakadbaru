<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('jenis_kelamin', 10)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('alamat', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn('jenis_kelamin',10);
            $table->dropColumn('email', 50);
            $table->dropColumn('alamat',50);
            $table->dropColumn('tanggal_lahir');
        });
    }
}
