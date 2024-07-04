<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsPaidEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_paid_equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->tinyInteger('status')->default(0)->comment('0: active, 1: deactive');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('ts_equipment_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantity')->nullable();
            $table->integer('unit')->default(0)->comment('0: tower, 1: book, 2: foot, 3: indivual, 4: set');
            $table->integer('price')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ts_paid_equipment');
    }
}
