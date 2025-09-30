<?php
// database/migrations/create_medical_record_images_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalRecordImagesTable extends Migration
{
    public function up()
    {
        Schema::create('medical_record_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->string('image_type'); // x-ray, intraoral, extraoral, etc.
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_record_images');
    }
}
