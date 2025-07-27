<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToCountersTable extends Migration
{
    public function up()
    {
        Schema::table('counters', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('icon');
            $table->enum('type', ['icon', 'image'])->default('icon')->after('image_url');
        });
    }

    public function down()
    {
        Schema::table('counters', function (Blueprint $table) {
            $table->dropColumn(['image_url', 'type']);
        });
    }
}
