<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialIconsTable extends Migration
{
    public function up()
    {
        Schema::create('social_icons', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Facebook, Twitter, Instagram, etc.
            $table->string('icon_class'); // fab fa-facebook, fab fa-twitter
            $table->string('url');
            $table->string('color')->default('#000000'); // Hex color for the icon
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('social_icons');
    }
}
