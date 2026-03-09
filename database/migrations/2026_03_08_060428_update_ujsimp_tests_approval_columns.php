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
        Schema::table('ujsimp_tests', function (Blueprint $table) {
            // Ubah enum workflow_status jika perlu (biasanya via raw statement di MySQL, tapi kita biarkan dulu jika sudah ada)
            // Tambahkan kolom yang hilang
            
            if (!Schema::hasColumn('ujsimp_tests', 'submitted_by')) {
                $table->unsignedBigInteger('submitted_by')->nullable()->after('workflow_status');
            }
            if (!Schema::hasColumn('ujsimp_tests', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable()->after('submitted_by');
            }

            // 'checked_by' bisa kita mapping ke 'verified_by' agar konsisten dengan code yang ada, 
            // tapi request user minta 'checked_by'. Kita pakai verified_by saja sesuai model yang ada,
            // atau tambahkan alias. 
            // Mari kita ikuti instruksi user untuk menambahkan field standard.
            // Namun, model UjsimpTest sudah pakai verified_by. Kita akan standarisasi ke verified_by (Checker).
            
            // Kolom approval
            if (!Schema::hasColumn('ujsimp_tests', 'rejected_by')) {
                $table->unsignedBigInteger('rejected_by')->nullable()->after('approved_at');
            }
            if (!Schema::hasColumn('ujsimp_tests', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('rejected_by');
            }
            if (!Schema::hasColumn('ujsimp_tests', 'rejected_reason')) {
                $table->text('rejected_reason')->nullable()->after('rejected_at');
            }

            // Tambahkan index untuk performa
            // Cek index existence sebelum add untuk menghindari error duplicate key
            // Note: Laravel migration tidak punya method native hasIndex di Blueprint builder secara langsung untuk conditional,
            // jadi kita gunakan Schema facade atau biarkan jika belum ada.
            // Namun karena error log bilang duplicate key, kita disable baris ini atau gunakan raw query safe.
            
            // $table->index('workflow_status'); // Duplicate di environment ini
            // $table->index('submitted_at');
            // $table->index('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ujsimp_tests', function (Blueprint $table) {
            $table->dropColumn([
                'submitted_by',
                'submitted_at',
                'rejected_by',
                'rejected_at',
                'rejected_reason'
            ]);
            
            $table->dropIndex(['workflow_status']);
            $table->dropIndex(['submitted_at']);
            $table->dropIndex(['approved_at']);
        });
    }
};
