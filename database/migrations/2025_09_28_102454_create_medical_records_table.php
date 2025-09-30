<?php
// database/migrations/create_medical_records_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // dokter/petugas
            $table->date('examination_date');
            $table->text('chief_complaint'); // keluhan utama
            $table->text('history_present_illness'); // riwayat penyakit sekarang
            $table->text('clinical_examination'); // pemeriksaan klinis
            $table->text('diagnosis'); // diagnosis
            $table->text('treatment_plan'); // rencana perawatan
            $table->text('treatment_performed'); // tindakan yang dilakukan
            $table->text('prescription')->nullable(); // resep obat
            $table->text('notes')->nullable(); // catatan tambahan
            $table->json('tooth_chart')->nullable(); // chart gigi dalam JSON
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_records');
    }
}