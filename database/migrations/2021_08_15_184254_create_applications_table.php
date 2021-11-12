<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id');
            $table->string('fio', 255);
            $table->bigInteger('inn');
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('additional_phone')->nullable();
            $table->string('mesto_raboty')->nullable();
            $table->string('doljnost')->nullable();
            $table->string('bolnichniy_list')->nullable();
            $table->string('osmotr')->nullable();
            $table->string('pcr')->nullable();
            $table->string('date_pcr')->nullable();
            $table->string('kt')->nullable();
            $table->string('kt_result')->nullable();
            $table->string('date_kt')->nullable();
            $table->string('percent_porojeniya')->nullable();
            $table->string('kt_input_drugoe')->nullable();
            $table->text('duchet')->nullable();
            $table->string('ber_ned')->nullable();
            $table->text('epid_okrujenie')->nullable();
            $table->string('ppm')->nullable();
            $table->string('nazvanie_ls')->nullable();
            $table->string('saturaciya')->nullable();
            $table->string('temperatura')->nullable();
            $table->string('slabost')->nullable();
            $table->string('rvota_toshnota')->nullable();
            $table->string('diareya')->nullable();
            $table->string('poterya_obonaniya')->nullable();
            $table->string('poterya_vkusa')->nullable();
            $table->string('kashel')->nullable();
            $table->string('zatrudnenoe_dixanie')->nullable();
            $table->string('odishka')->nullable();
            $table->string('naznachit_kt')->nullable();
            $table->text('naznachit_analiz')->nullable();
            $table->string('dopolnitelno')->nullable();
            $table->text('naznacheni_ls')->nullable();
            $table->string('vakcinaciya')->nullable();
            $table->string('date_1_etap')->nullable();
            $table->string('date_2_etap')->nullable();
            $table->string('preparat')->nullable();
            $table->string('predvoritelniy_diagnoz')->nullable();
            $table->string('stepen')->nullable();
            $table->string('isxod')->nullable();
            $table->string('status', 100)->nullable();
            $table->integer('is_route_sheet')->default(0);
            $table->enum('route_sheet_status', ['Новая', 'Выполнена', 'Отменена'])->nullable();
            $table->integer('srochno')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
