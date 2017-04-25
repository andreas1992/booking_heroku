<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Room; 
class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {

            $table->integer('id')->unsigned();
            $table->primary('id');
            
            $table->text('body');
            $table->timestamps();
        });

        $room = new Room;
        $room->id = 1;
        $room->body = 'Tangen';
        $room->save();

        $room2 = new Room;
        $room2->id = 2;
        $room2->body = 'Corneren';
        $room2->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
