<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Booking;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('booking', function (Blueprint $table) {
            $table->increments('id');
            $table->time('from');
            $table->time('to');

            $table->integer('room_id')->unsigned();
            $table->foreign('room_id')->references('id')->on('rooms');

            $table->rememberToken();
            $table->timestamps();
        });

        $booking1 = new Booking;
        $booking1->from = '08:00:00';
        $booking1->to = '09:00:00';

        $booking1->room_id = 1;
        $booking1->save();

        $booking2 = new Booking;
        $booking2->from = '12:00:00';
        $booking2->to = '13:00:00';

        $booking2->room_id = 1;
        $booking2->save();

        $booking3 = new Booking;
        $booking3->from = '15:00:00';
        $booking3->to = '16:00:00';

        $booking3->room_id = 2;
        $booking3->save();



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('booking');
    }
}
