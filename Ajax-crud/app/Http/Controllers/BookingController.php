<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Booking;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Laster opp databasetabellen når siden lastes opp
        $booking = DB::table('booking')->get();
        $rooms = DB::table('rooms')->get();
        

        return view('/fargeklatt', compact('booking', 'rooms'));

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $booking = new Booking;

        $booking -> from = $request->from;
        $booking -> to = $request->to;
        $booking -> room_id = $request->room_id; //skifte til room_id
        $dateStr = $request->dateString;
        $booking -> dateString = $dateStr;

        $booking->save();

        //return Redirect('/fargeklatt');
        return redirect()->back()->with(compact('dateStr'));
        //return redirect()->route('fargeklatt', ['dateStr' => $dateStr]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = DB::table('booking')->find($id);

        return view('bookings.show', compact('booking'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('booking')->where('id', $id)->delete();

        return redirect('/fargeklatt');
    }
}
