<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_events', function (Blueprint $table) {
            // Make original title nullable since frontend uses service_name instead
            if (Schema::hasColumn('service_events', 'title')) {
                $table->string('title')->nullable()->change();
            }

            if (!Schema::hasColumn('service_events', 'service_name')) {
                $table->string('service_name')->nullable()->after('title');
            }

            if (!Schema::hasColumn('service_events', 'preacher')) {
                $table->string('preacher')->nullable()->after('description');
            }

            if (!Schema::hasColumn('service_events', 'preacher_description')) {
                $table->string('preacher_description')->nullable()->after('preacher');
            }

            if (!Schema::hasColumn('service_events', 'message')) {
                $table->text('message')->nullable()->after('preacher_description');
            }

            if (!Schema::hasColumn('service_events', 'attendance_children')) {
                $table->unsignedInteger('attendance_children')->default(0)->after('message');
            }

            if (!Schema::hasColumn('service_events', 'attendance_women')) {
                $table->unsignedInteger('attendance_women')->default(0)->after('attendance_children');
            }

            if (!Schema::hasColumn('service_events', 'attendance_men')) {
                $table->unsignedInteger('attendance_men')->default(0)->after('attendance_women');
            }

            if (!Schema::hasColumn('service_events', 'total_attendance')) {
                $table->unsignedInteger('total_attendance')->default(0)->after('attendance_men');
            }

            if (!Schema::hasColumn('service_events', 'total_offerings')) {
                $table->decimal('total_offerings', 12, 2)->default(0)->after('total_attendance');
            }

            if (!Schema::hasColumn('service_events', 'leaders_on_duty')) {
                $table->string('leaders_on_duty')->nullable()->after('total_offerings');
            }
        });
    }

    public function down(): void
    {
        Schema::table('service_events', function (Blueprint $table) {

            $columns = [
                'service_name',
                'preacher',
                'preacher_description',
                'message',
                'attendance_children',
                'attendance_women',
                'attendance_men',
                'total_attendance',
                'total_offerings',
                'leaders_on_duty',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('service_events', $column)) {
                    $table->dropColumn($column);
                }
            }

        });
    }
};