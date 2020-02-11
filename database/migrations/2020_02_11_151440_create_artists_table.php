<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Artists', function (Blueprint $table) {
            $table->bigIncrements('ArtistID');
            $table->string('ArtistName', 200);
            $table->string('AlbumName', 200);
            $table->string('ImageURL', 200)->nullable();
            $table->date('ReleaseDate');
            $table->decimal('Price', 10, 2);
            $table->string('SampleURL', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Artists');
    }
}
