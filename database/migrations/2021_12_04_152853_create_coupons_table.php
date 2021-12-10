<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements( 'id' );
            $table->string( 'code' )->unique()->nullable();
            $table->string( 'name' );
            $table->text( 'description' )->nullable();
            $table->integer( 'uses' )->unsigned()->nullable();
            $table->integer( 'max_uses' )->unsigned()->nullable();
            $table->integer( 'max_uses_user' )->unsigned()->nullable();
            $table->float( 'discount_amount' )->unsigned()->nullable();
            $table->float( 'discount_percentage' )->unsigned()->nullable();
            $table->float('max_amount')->unsigned()->nullable();
            $table->boolean( 'is_fixed' )->default( true );
            $table->timestamp( 'starts_at')->nullable();
            $table->timestamp( 'expires_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
