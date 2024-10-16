<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ships', function (Blueprint $table) {
            $table->id();
            $table->string('mmsi')->unique();
            $table->string('name')->nullable();
            $table->string('callsign')->nullable();
            $table->string('imo')->nullable();
            $table->integer('dimA')->nullable();
            $table->integer('dimB')->nullable();
            $table->integer('dimC')->nullable();
            $table->integer('dimD')->nullable();
            $table->string('cargo')->nullable();
            $table->decimal('draught', 5, 2)->nullable();

            // Audit Fields
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();

            // Indexes
            $table->index('mmsi');
        });

        // Adding the foreign keys
        Schema::table('ships', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ships');
    }
};
