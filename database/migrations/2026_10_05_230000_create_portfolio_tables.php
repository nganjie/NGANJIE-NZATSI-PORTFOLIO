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
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->string('slug')->unique();
            $table->json('summary');
            $table->string('type', 20);
            $table->json('context')->nullable();
            $table->json('role')->nullable();
            $table->json('period')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('repository_url')->nullable();
            $table->json('case_study')->nullable();
            $table->json('lesson')->nullable();
            $table->json('results')->nullable();
            $table->json('tags')->nullable();
            $table->string('accent_color', 20)->default('violet');
            $table->string('status', 20)->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('position')->default(0);
            $table->json('seo_title')->nullable();
            $table->json('seo_description')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'position']);
            $table->index(['is_featured', 'position']);
        });

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('display_name');
            $table->json('headline');
            $table->json('tagline');
            $table->json('tagline_highlight')->nullable();
            $table->json('bio');
            $table->string('city')->nullable();
            $table->boolean('is_available')->default(false);
            $table->json('availability_label')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->date('cv_updated_at')->nullable();
            $table->foreignId('featured_project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('project_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('position')->default(0);
            $table->json('title');
            $table->json('body')->nullable();
            $table->timestamps();
        });

        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->json('category');
            $table->boolean('show_on_home')->default(false);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('project_technology', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('technology_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('position')->default(0);
            $table->primary(['project_id', 'technology_id']);
        });

        Schema::create('skill_domains', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('description');
            $table->json('tags');
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20);
            $table->string('organization');
            $table->string('location')->nullable();
            $table->json('title');
            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();
            $table->json('date_label')->nullable();
            $table->json('highlights')->nullable();
            $table->boolean('is_current')->default(false);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('process_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('position')->default(0);
            $table->json('title');
            $table->json('body');
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20);
            $table->string('name');
            $table->string('email');
            $table->text('body');
            $table->string('ip_hash', 64)->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['archived_at', 'created_at']);
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('value')->nullable();
            $table->timestamps();
        });

        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('referrer')->nullable();
            $table->timestamp('viewed_at')->useCurrent();

            $table->index(['path', 'viewed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('process_steps');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('skill_domains');
        Schema::dropIfExists('project_technology');
        Schema::dropIfExists('technologies');
        Schema::dropIfExists('project_tasks');
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('projects');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_login_at');
        });
    }
};
