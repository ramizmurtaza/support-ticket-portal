<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no', 20)->unique();
            $table->string('system_id', 50)->index();
            $table->string('client_name', 100)->nullable();
            $table->string('client_email', 150)->index();
            $table->enum('type', ['bug', 'support', 'feature'])->default('bug');
            $table->string('title', 255);
            $table->text('description');
            $table->enum('status', ['open', 'in_progress', 'waiting_client', 'resolved', 'closed'])->default('open');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->string('jira_task_id', 50)->nullable();
            $table->string('assigned_to', 100)->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
