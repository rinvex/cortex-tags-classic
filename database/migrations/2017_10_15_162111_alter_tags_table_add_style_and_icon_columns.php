<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTagsTableAddStyleAndIconColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(config('rinvex.tags.tables.tags'), function (Blueprint $table) {
            $table->string('style')->after('group')->nullable();
            $table->string('icon')->after('style')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(config('rinvex.tags.tables.tags'), function (Blueprint $table) {
            $table->dropColumn('icon');
            $table->dropColumn('style');
        });
    }
}
