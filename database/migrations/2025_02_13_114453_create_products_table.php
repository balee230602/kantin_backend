<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // bigint(20) unsigned auto-increment primary key
            $table->string('name', 255); // varchar(255)
            $table->text('description'); // text
            $table->integer('price'); // int(11)
            $table->integer('stock'); // int(11)
            $table->enum('category', ['food', 'drink', 'snack']); // ENUM untuk kategori produk
            $table->string('image', 255);
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
