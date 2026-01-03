<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik')->unique()->after('id');
            $table->string('nip')->nullable()->unique()->after('nik');
            $table->string('no_telepon', 20)->nullable()->after('email');
            $table->text('alamat')->nullable()->after('no_telepon');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('alamat');
            $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('agama')->nullable()->after('tanggal_lahir');
            $table->enum('role', ['admin', 'karyawan'])->default('karyawan')->after('agama');
            $table->unsignedBigInteger('jabatan_id')->nullable()->after('role');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('jabatan_id');
            $table->date('tanggal_masuk')->nullable()->after('status');
            $table->string('foto')->nullable()->after('tanggal_masuk');
            $table->foreignId('jadwal_absensi_id')->nullable()->constrained('jadwal_absensi')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Daftar semua kolom yang mungkin ingin dihapus
            $columnsToDrop = [
                'nik',
                'nip',
                'no_telepon',
                'alamat',
                'jenis_kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'agama',
                'role',
                'jabatan_id',
                'status',
                'tanggal_masuk',
                'foto'
            ];

            // Filter hanya kolom yang benar-benar ada di tabel
            $existingColumns = [];
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $existingColumns[] = $column;
                }
            }

            // Hapus kolom hanya jika ada
            if (!empty($existingColumns)) {
                $table->dropColumn($existingColumns);
            }
        });
    }
};
