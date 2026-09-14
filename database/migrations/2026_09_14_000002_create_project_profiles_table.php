<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up(): void {
        Schema::create('project_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('headline')->nullable();
            $table->string('school')->nullable();
            $table->string('major')->nullable();
            $table->string('skills', 500)->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('github_url', 500)->nullable();
            $table->string('website_url', 500)->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
        DB::table('project_profiles')->insert([
            'id' => 1, 'name' => 'Adrian', 'headline' => 'Pengembang POS Adrian',
            'bio' => 'Saya mengembangkan aplikasi Point of Sale ini untuk membantu pengelolaan produk dan pencatatan transaksi penjualan.',
            'skills' => 'Laravel, PHP, MySQL, Bootstrap', 'created_at' => now(), 'updated_at' => now(),
        ]);
    }
    public function down(): void { Schema::dropIfExists('project_profiles'); }
};
