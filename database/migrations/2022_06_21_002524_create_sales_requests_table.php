<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('mall_id');
            $table->string('sales_request_code')->nullable();
            $table->string('quotation_addressee')->nullable();
            $table->string('requester')->nullable();
            $table->date('date_needed')->nullable();
            $table->string('remarks')->nullable();
            $table->string('project_requirement_files')->nullable();
            $table->string('status')->nullable();
            $table->string('project_title')->nullable();
            $table->string('pm_supervisor_id')->nullable();
            $table->string('pm_assigned_id')->nullable();
            $table->string('pm_approval_status')->nullable();
            $table->string('pm_remarks')->nullable();
            $table->string('category')->nullable();
            $table->integer('revision')->nullable();
            $table->string('proof_of_sending')->nullable();
            $table->string('po_ntp_files')->nullable();
            $table->string('proposal_files')->nullable();
            $table->string('bid_summary_files')->nullable();
            $table->string('contractor_ntp')->nullable();
            $table->string('cer-files')->nullable();
            $table->string('contractor_po')->nullable();
            $table->string('cari')->nullable();
            $table->string('first_copa')->nullable();
            $table->string('second_copa')->nullable();
            $table->string('coca')->nullable();
            $table->string('proof_of_cancellation')->nullable();
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
        Schema::dropIfExists('sales_requests');
    }
};
