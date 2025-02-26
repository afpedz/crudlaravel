<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); 
            $table->string('product_code')->unique(); //should be, Randomly generated product code or user defined
            $table->string('description');
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Foreign key to categories
            $table->foreignId('unit_id')->constrained()->onDelete('cascade'); // Foreign key to units
            $table->decimal('price', 10, 2); 
            $table->timestamps();
            $table->softDeletes()->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}