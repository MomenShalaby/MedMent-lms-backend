<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {

            $table->id();
            $table->text('course_name');
            $table->text('course_title')->nullable();
            $table->longText('description')->nullable();
            // $table->foreignId('categories_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            // $table->foreignIdFor(Category::class);

            $table->string('image')->nullable();
            $table->string('instructor')->nullable();
            $table->string('video')->nullable();
            $table->string('label')->nullable();
            $table->string('duration')->nullable();
            $table->string('resources')->nullable();
            $table->string('certificate')->nullable();
            $table->text('prerequisites')->nullable();
            $table->string('featured')->nullable();
            $table->integer('price')->nullable();
            $table->enum('status', ['inactive', 'active'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
