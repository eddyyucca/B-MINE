<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates all tables for the bmine database structure
     */
    public function up(): void
    {
        // Create access table
        Schema::create('access', function (Blueprint $table) {
            $table->id('id_access');
            $table->string('access_data', 25);
            $table->string('nik_access', 100);
        });

        // Create area table
        Schema::create('area', function (Blueprint $table) {
            $table->id('id_area');
            $table->string('nama_area', 50);
        });

        // Create data_m_s table
        Schema::create('data_m_s', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 100)->nullable();
            $table->string('nik', 50)->nullable();
            $table->string('nama', 100)->nullable();
            $table->string('jab', 100)->nullable();
            $table->string('dept', 100)->nullable();
            $table->string('date_req', 30)->nullable();
            $table->string('expiry_date', 30);
            $table->text('foto_path')->nullable();
            $table->text('medical_path')->nullable();
            $table->text('drivers_license_path')->nullable();
            $table->text('attachment_path')->nullable();
            $table->text('sio_path')->nullable();
            $table->string('validasi_in', 50)->nullable();
            $table->string('status', 25)->nullable();
            $table->string('dep_req', 100)->nullable();
            $table->string('sio_status', 25)->nullable();
            $table->string('access', 255)->nullable();
            $table->text('ktt')->nullable();
            $table->timestamps();
            $table->boolean('status_access')->default(0);
        });

        // Create data_reject table
        Schema::create('data_reject', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 255);
            $table->string('nik', 255);
            $table->string('nama', 255);
            $table->string('jab', 255);
            $table->string('dept', 255);
            $table->string('reject_history', 255)->nullable();
        });

        // Create data_req table
        Schema::create('data_req', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 100);
            $table->string('nik', 50);
            $table->string('nama', 100);
            $table->string('jab', 100);
            $table->string('dept', 100);
            $table->string('date_req', 30);
            $table->text('foto_path')->nullable();
            $table->text('medical_path')->nullable();
            $table->text('drivers_license_path')->nullable();
            $table->text('attachment_path')->nullable();
            $table->string('expiry_date', 30);
            $table->text('sio_path')->nullable();
            $table->string('validasi_in', 50);
            $table->string('status', 25);
            $table->string('dep_req', 100);
            $table->string('sio_status', 25);
            $table->string('access', 255);
            $table->text('ktt');
        });

        // Create karyawan table
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id('id_kar');
            $table->string('nik', 20);
            $table->string('nama', 100);
            $table->string('departement', 100);
            $table->string('jabatan', 100);
            $table->string('status_mp', 100);
            $table->string('email', 100);
            $table->text('password');
            $table->enum('level', ['admin', 'user', 'she', 'pjo', 'section_admin']);
        });

        // Create login_external table
        Schema::create('login_external', function (Blueprint $table) {
            $table->id('id_login_ext');
            $table->string('nama', 50);
            $table->string('email', 50);
            $table->text('password');
            $table->string('level', 50);
            $table->string('area', 30)->nullable();
        });

        // Create units table
        Schema::create('units', function (Blueprint $table) {
            $table->id('id_units');
            $table->string('nama_unit', 100);
            $table->string('kode_unit', 100);
            $table->string('sio', 100);
        });

        // Create user_unit table
        Schema::create('user_unit', function (Blueprint $table) {
            $table->id('id_user_unit');
            $table->string('unit', 100);
            $table->string('type_unit', 100);
            $table->string('id_uur', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_unit');
        Schema::dropIfExists('units');
        Schema::dropIfExists('login_external');
        Schema::dropIfExists('karyawan');
        Schema::dropIfExists('data_req');
        Schema::dropIfExists('data_reject');
        Schema::dropIfExists('data_m_s');
        Schema::dropIfExists('area');
        Schema::dropIfExists('access');
    }
};