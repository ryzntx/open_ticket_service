<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug')->after('name')->unique()->nullable()->comment('Unique slug for the category');
            $table->index('slug', 'category_slug_index'); // Adding an index for the
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('category_slug_index'); // Dropping the index
            $table->dropColumn('slug'); // Dropping the slug column
        });
    }
};
