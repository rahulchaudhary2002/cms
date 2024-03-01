<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateMonthlyTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Monthly Table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yearMonth = date('Ym');

        Schema::create('student_attendances_' . $yearMonth, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->date('date');
            $table->enum('status', ['present', 'absent']);
            $table->unique(['student_id', 'course_id', 'date']);
            $table->timestamps();
        });

        $this->info("Migration is completed.");
    }
}
