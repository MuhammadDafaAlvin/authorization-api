<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nim');
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->date('tanggal_lahir');
            $table->string('program_studi');
            $table->year('angkatan');
            $table->string('email');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
