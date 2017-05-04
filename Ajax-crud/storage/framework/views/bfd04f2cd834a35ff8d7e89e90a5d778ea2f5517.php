<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <style>
    .roomTable {
      width: 100%;
      color: black !important;
    }
    .roomTd, .roomTr {
      border: 1px solid lightgrey;
      text-align: center;
    }
    .roomTd {
      padding: 1% !important;
    }
    #firstTd {
      width: 20%;
    }
    .form-horizontal {
      margin-left: 15px !important;
      margin-right: 15px !important;
    }
    .colorMe {
      background-color: green;
    }
    </style>
    <script>
    $(document).ready(function(){
      $("#date").datepicker({
        format: 'dd/mm/yyyy',
        language: 'nb',
        todayHighlight: true,
        //calendarWeeks: true,
        //autoclose: true,
        weekStart: 1,
      }).datepicker("setDate", new Date());

    //var dateStr = "";
    var dateStr = <?php echo json_encode(session('dateStr')); ?>

    //alert(dateStr);

    /* Vise tabeller for riktig dato, og sørge for at det er i riktig dato-format */
    var strDateTime = "";
    if(dateStr == null) {
      var currDate = new Date($('#date').datepicker('getDate'));
      strDateTime =  currDate.getDate() + "/" + (currDate.getMonth()+1) + "/" + currDate.getFullYear();
      /* Hente ut dagens dato */
    }
    else {
      strDateTime = dateStr;  
      var parts = dateStr.split('/');
      //please put attention to the month (parts[0]), Javascript counts months from 0:
      // January - 0, February - 1, etc
        //parts[2] = year, parts[1]-1 = month, parts[0] = day
      var mydate = new Date(parts[2],parts[1]-1, parts[0]);
      //alert("strDateTime: " + strDateTime);
      //alert(mydate.toDateString()); 
      $('#date').datepicker("setDate", mydate);
    }
    /*var currDate = new Date($('#date').datepicker('getDate'));
    var strDateTime =  currDate.getDate() + "/" + (currDate.getMonth()+1) + "/" + currDate.getFullYear();
    //alert("dagens dato: " + strDateTime);*/

/*
    var date_input=$('div[name="date"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
      format: 'DD DD/MM/YYYY',
      container: container,
      todayHighlight: true,
      autoclose: true,
      language: 'nb',
      orientation: 'top',
      setDate: new Date(),
    });*/

    /* Limt inn fra her.. */
/*
    $('.next-day').on("click", function () {
      var date = $('#date').datepicker('getDate');
      date.setTime(date.getTime() + (1000*60*60*24))
        $('#date').datepicker("setDate", date);
        var currDate = new Date($('#date').datepicker('getDate'));
        var strDateTime2 =  currDate.getDate() + "/" + (currDate.getMonth()+1) + "/" + currDate.getFullYear();
        alert(strDateTime2);
        displayBookings(bookings, strDateTime2);
    });

    $('.prev-day').on("click", function () {
      var date = $('#date').datepicker('getDate');
      date.setTime(date.getTime() - (1000*60*60*24))
        $('#date').datepicker("setDate", date);
        //alert($('#date').datepicker('getDate'));
        var currDate = new Date($('#date').datepicker('getDate'));
        var strDateTime2 =  currDate.getDate() + "/" + (currDate.getMonth()+1) + "/" + currDate.getFullYear();
        alert(strDateTime2);
        displayBookings(bookings, strDateTime2);
    });    
*/
    /* ..til her */

    $('.datetimepicker3').each(function(k, v) {
      var $input = $(v).find('.datetimepicker3');
        $input.datetimepicker({
          format: 'HH:mm',
          stepping: 30,
          disabledHours: [0,1,2,3,4,5,6,7,17,18,19,20,21,22,23]
        });
      $(v).find('span.input-group-addon').click(function(e) {
        $input.focus();
      });

    });

    var rooms = <?php echo str_replace("'", "\'", json_encode($rooms)); ?>;

    var bookings = <?php echo str_replace("'", "\'", json_encode($booking)); ?>;

    $('#calender-table').empty();

    // Takes starttime and endtime, return list with the times in half hour format
    var makeTimeHalfHour = function(start_tid, slutt_tid) {
      var x = 30; //minutes interval
      var times = []; // time array
      var tt = start_tid*60; // start time

      //loop to increment the time and push results in array
      for (var i=0;tt<slutt_tid*60; i++) {
        var hh = Math.floor(tt/60); // getting hours of day in 0-24 format
        var mm = (tt%60); // getting minutes of the hour in 0-55 format
        times[i] = ("0" + (hh)).slice(-2) + ':' + ("0" + mm).slice(-2); // pushing data in array in [00:00 - 12:00 AM/PM format]
        tt = tt + x;
      }
      return times;
    }

    var times = makeTimeHalfHour(8, 17);
/*
    for (var i = 0; i < rooms.length; i++) {
      var roomId = rooms[i]['id'];
      var table = '<div class="col-sm-5"><table class="roomTable" id=' + roomId + '>'+ rooms[i]['body'] +'</table></div>';
      $(table).appendTo('#calender-table');

      for(var j = 0; j < times.length; j++) {
        $('<tr class="roomTr"><th class="roomTd" id="firstTd">'+ times[j] +'</th><td role="button" class="roomTd tdspacing" data-toggle="modal" data-target="#myModal" id=' + (times[j]+':00') + ' name='+ (times[j]+':00') +'></td></tr>').appendTo('table#'+ roomId +'');
      }

    }*/

    var makeRoomTables = function(rooms, times) {
      for (var i = 0; i < rooms.length; i++) {
          var roomId = rooms[i]['id'];
          var table = '<div class="col-sm-5"><table class="roomTable" id=' + roomId + '>'+ rooms[i]['body'] +'</table></div>';
          $(table).appendTo('#calender-table');

          for(var j = 0; j < times.length; j++) {
            $('<tr class="roomTr"><th class="roomTd" id="firstTd">'+ times[j] +'</th><td role="button" class="roomTd tdspacing" data-toggle="modal" data-target="#myModal" id=' + (times[j]+':00') + ' name='+ (times[j]+':00') +'></td></tr>').appendTo('table#'+ roomId +'');
          }
        }
      
    };

    makeRoomTables(rooms, times);

    //bookings[i]['room_id']

    // bookings[0]['room_id'] = 1
    // bookings[1]['room_id'] = 2
    // bookings[2]['room_id'] = 1

    //var tdsInTable = $('table#'+ '1' +'').find('td');

    var makeBookingClickable = function () {
      $(".colorMe").attr("data-target", "#booking_modal");
      $(".colorMe").attr("data-toggle", "modal");
    }

    var displayBookings = function(bookings, strDateTime) {

      for(var i = 0; i<bookings.length; i++) {

        //alert(bookings[i]['dateString']);
        if(bookings[i]['dateString'] == strDateTime) {

          var tdsInTable = $('table#'+ bookings[i]['room_id'] +'').find('td');

          for(var j = 0; j <tdsInTable.length; j++) {

            if (bookings[i]['from'] == tdsInTable[j].id) {
              $(tdsInTable[j]).append(bookings[i]['from']).attr('id', 'bookStart').addClass('colorMe booked');
              $(tdsInTable[j]).append('<a href="/fargeklatt/'+bookings[i]['id']+'" id="'+ bookings[i]['id'] +'">vis booking</a>');
            } 
            else if (bookings[i]['to'] == tdsInTable[j].id) {
              $(tdsInTable[j-1]).append(bookings[i]['to']).attr('id', 'bookEnd').addClass('colorMe booked');
            }
          }
        }
      }
    };

    displayBookings(bookings, strDateTime);

    // Fargelegge alle celler/td fra og med bookstart til og med bookend, for alle celler i tabell
    var colorBookings = function() {
      var start = false;
          $("table td").filter(function(){
            if(this.id == "bookStart" || start) {
              if(this.id == "bookEnd"){
                  start = false;
                  return true;
              }
              start = true;
          }
        return start;

      }).addClass('colorMe booked');
    };

    colorBookings();
    makeBookingClickable();


    /* Event handlers for hva som skjer når selected day, next day, eller prev day trykkes på */



    $('.next-day').on("click", function () {
      var date = $('#date').datepicker('getDate');
      date.setTime(date.getTime() + (1000*60*60*24))
        $('#date').datepicker("setDate", date);
        /* Sletter bookings som er satt på tabellene, dvs fjerner "booked" og "bookedFrom" attributter */
        $('.roomTable td').filter(function() {
          $(this).attr('class', 'roomTd tdspacing').attr('id', $(this).attr("name")).html("");
        });
        var currDate = new Date($('#date').datepicker('getDate'));
        var strDateTime2 =  currDate.getDate() + "/" + (currDate.getMonth()+1) + "/" + currDate.getFullYear();
        //alert(strDateTime2);
        /* Går gjennom bookings og setter inn de som skal inn på den dagen det er trykket på */
        displayBookings(bookings, strDateTime2);
        colorBookings();
    });

    $('.prev-day').on("click", function () {
      var date = $('#date').datepicker('getDate');
      date.setTime(date.getTime() - (1000*60*60*24))
        $('#date').datepicker("setDate", date);
        /* Sletter bookings som er satt på tabellene, dvs fjerner "booked" og "bookedFrom" attributter */
         $('.roomTable td').filter(function() {
          $(this).attr('class', 'roomTd tdspacing').attr('id', $(this).attr("name")).html("");
        });
        var currDate = new Date($('#date').datepicker('getDate'));
        var strDateTime2 =  currDate.getDate() + "/" + (currDate.getMonth()+1) + "/" + currDate.getFullYear();
        //alert(strDateTime2);
        /* Går gjennom bookings og setter inn de som skal inn på den dagen det er trykket på */
        displayBookings(bookings, strDateTime2);
        colorBookings();
    });    


    /* bootstrap-datepicker ting som kjører når event 'changeDate' oppstår */
    $('#date').datepicker().on('changeDate', function(e) {
          /* Sletter bookings som er satt på tabellene, dvs fjerner "booked" og "bookedFrom" attributter */
           $('.roomTable td').filter(function() {
            $(this).attr('class', 'roomTd tdspacing').attr('id', $(this).attr("name")).html("");
          });
          var currDate = new Date($('#date').datepicker('getDate'));
          var strDateTime2 =  currDate.getDate() + "/" + (currDate.getMonth()+1) + "/" + currDate.getFullYear();
          //alert(strDateTime2);
          /* Går gjennom bookings og setter inn de som skal inn på den dagen det er trykket på */
          displayBookings(bookings, strDateTime2);
          colorBookings();
      });




$('table#'+ 1 +' td').filter(function(){

            var thisName = $(this).attr("name");
            console.log(thisName);
            var thisClass = $(this).attr("class");
            console.log(thisClass);
          });



/*
    $('.test').click(function(e) {
      alert('hei');
      $(this).append('<p>hallo</p>');
    });*/

/* Funksjon som blir trigget når du vil lage en ny booking ved å trykke et sted i tabellen */
    $('.roomTable').click(function(e) {
      var tableID = this.getAttribute("id");
      $('.room_id').val(tableID);

      var currDate = new Date($('#date').datepicker('getDate'));
      var strDateTime2 =  currDate.getDate() + "/" + (currDate.getMonth()+1) + "/" + currDate.getFullYear();
      $('.dateString').val(strDateTime2);
    });

/*
    var getHowManyLinesInBooking = function(bookedFrom, bookedTo, room_id) {
      var numberOfBookings = -1;
      var start = false;
      $('table#'+ room_id +' td').filter(function(){
        //feks 08:30:00
        var thisName = $(this).attr("name");
        if(thisName == bookedFrom || start) {
          if(thisName == bookedTo) {
            start = false;
            numberOfBookings ++;
            return numberOfBookings;
          }
          start = true;
          numberOfBookings ++;
        }
      });
      return numberOfBookings;
    };


    $('.save_booking').click(function(e) {
      // bookedFrom = 12:00:00
      var bookedFrom = $(".datetimepicker3").find("input[name='from']").val() + ":00";
      alert("booked from: " + bookedFrom);
      // bookedTo = 14:00:00
      var bookedTo = $(".datetimepicker3").find("input[name='to']").val() + ":00";
      alert("booked to: " + bookedTo);
      // room_id = 2
      var room_id = $(".datetimepicker3").find("input[name='room_id']").val();
      alert("room_id: " + room_id);

      var lines = getHowManyLinesInBooking(bookedFrom, bookedTo, room_id);


    });
*/


    var checkIfBooked = function(bookedFrom, bookedTo, room_id) {
      var start = false;
      //var returnStr = "booking proceed";
      var bookable = true;
      $('table#'+ room_id +' td').filter(function(){
        //feks 08:30:00
        var thisName = $(this).attr("name");
        //alert("thisName: " + thisName);
        var thisClass = $(this).attr("class");
        //alert("thisClass: " + thisClass);

        //alert("returnStr: " + returnStr);
        if(thisName == bookedFrom || start) {
          //alert(thisName + " = " + bookedFrom);
          if(thisName == bookedTo) {
            //alert(thisName + " = " + bookedTo);
            start = false;
            if(thisClass == 'roomTd tdspacing colorMe booked') {
              //returnStr = "can't book: the room is already booked at the given times";
              //bookable = false;
              return false;
            }
            return false; // Tilsvarende break;
          }
          start = true;
          if(thisClass == 'roomTd tdspacing colorMe booked') {
            //returnStr = "can't book: the room is already booked at the given times";
            bookable = false;
            return false;
        }
      }
    });
    //return returnStr;
    return bookable;
  };



  $('.save_booking').click(function(e) {
      // bookedFrom = 12:00:00
      var bookedFrom = $(".datetimepicker3").find("input[name='from']").val() + ":00";
      //alert("booked from: " + bookedFrom);
      // bookedTo = 14:00:00
      var bookedTo = $(".datetimepicker3").find("input[name='to']").val() + ":00";
      //alert("booked to: " + bookedTo);
      // room_id = 2
      var room_id = $(".datetimepicker3").find("input[name='room_id']").val();
      //alert("room_id: " + room_id);

      var bookCheck = checkIfBooked(bookedFrom, bookedTo, room_id);
      //alert("bookable = " + bookCheck);

      if(bookCheck == false) {
        alert("Can't book: the room is already booked at the given times");
        //$('.form-horizontal').attr('method', "GET");
        //$('.form-horizontal').val();
        $('.save_booking').attr('type', "button");
        $('#myModal').modal('hide');
      }
      else {
        $('.save_booking').attr('type', "sumbit button");
      }

    });



/*
    $('.save_booking').click(function(e) {
      // bookedFrom = 12:00:00
      var bookedFrom = $(".datetimepicker3").find("input[name='from']").val() + ":00";
      alert("booked from: " + bookedFrom);
      // bookedTo = 14:00:00
      var bookedTo = $(".datetimepicker3").find("input[name='to']").val() + ":00";
      alert("booked to: " + bookedTo);
      // room_id = 2
      var room_id = $(".datetimepicker3").find("input[name='room_id']").val();
      alert("room_id: " + room_id);    

          //tabell 2 sine td
      var numberOfBookings;
          $('table#'+ room_id +' td').filter(function(){

            var thisName = $(this).attr("name");
            console.log(thisName);
            var thisClass = $(this).attr("class");
            console.log(thisClass);

            var bookingsList = [];


            // lage en liste av bookings mellom bookedFrom og bookedTo
            if(thisName == bookedFrom) {
              bookingsList.put(thisName);
            }



            if(thisName == bookedFrom || thisName == bookedTo) {
              alert("this name: " + thisName);
                if(thisClass == 'roomTd tdspacing colorMe booked') {
                  alert('td has booking at: ' + thisName);
                  return false;
                }
            }

            // proceed with booking




            //this[0] 08:00:00 != 12:00:00
            //this[8] 12:00:00 == 12:00:00
              //
              /*
            if(this.id == bookedFrom || start) {
              if(this.id == bookedTo){
                  start = false;
                  return true;
              }


              start = true;
          }
        return start;
      
    });
});*/

/*


    for(var i = 0; i<bookings.length; i++) {
      console.log(bookings[i]['from'] + " to:" + bookings[i]['to']);
    }


    var inputs = document.getElementsByTagName("td");

    for(var i = 0; i < bookings.length; i++) {
      

      for (var j = 0; j < inputs.length; j++) {
        if (bookings[i]['from'] == inputs[j].id) {
          $(inputs[j]).append(bookings[i]['from']).attr('id', 'bookStart');
        } 
        else if (bookings[i]['to'] == inputs[j].id) {
          $(inputs[j-1]).append(bookings[i]['to']).attr('id', 'bookEnd').addClass('colorMe');
        }
      }


      var start = false;
          $("table td").filter(function(){
            if(this.id == "bookStart" || start) {
              if(this.id == "bookEnd"){
                  start = false;
                  return true;
              }
              start = true;
          }
        return start;

      }).addClass('colorMe');

    }

      $(".save_booking").click(function () {
      var printme = $(".datetimepicker3").find("input[name='from']").val();
      var printme2 = $(".datetimepicker3").find("input[name='to']").val();

      console.log(printme);
      console.log(printme2);

      //var holdId = $('td').attr('id');
      var inputs = document.getElementsByTagName("td");

      


      for (var i = 0; i < inputs.length; i++) {
        if (printme == inputs[i].id) {
          $(inputs[i]).append(printme).attr('id', 'bookStart');
        } 
        else if (printme2 == inputs[i].id) {
          $(inputs[i]).append(printme2).attr('id', 'bookEnd');
        }
      }
            var start = false;
          $("table td").filter(function(){
            if(this.id == "bookStart" || start) {
              if(this.id == "bookEnd"){
                  start = false;
                  return true;
              }
              start = true;
          }
        return start;

      }).addClass('colorMe');


    });

*/




         /*var start = false;
          $("table td").filter(function(){
            if(this.id == "bookStart" || start) {
              if(this.id == "bookEnd"){
                  start = false;
                  return true;
              }
              start = true;
          }
        return start;

      }).addClass('colorMe');*/
});

    </script>
  </head>
  <body>
<!--
  <p> dateStr = <?php echo e(session('dateStr')); ?>

    <?php if(session()->has('dateStr')): ?>
      <div class="alert alert-success">
        <?php echo e(session('dateStr')); ?>

      </div>
    <?php endif; ?>
  </p>-->
  <div class="container">
    <div class="row" id="calender_date">
        <div class="calendar_top page-header">
          <div class="row">
            <div class="col-xs-2 col-sm-4 col-md-4 text-right">
              <a class="btn_bookingVCalender btn prev-day"><span class="glyphicon glyphicon-chevron-left"></span><span class="hidden-xs"> Forrige dag</span></a>
            </div>
            <div class="col-xs-8 col-sm-4 col-md-4 text-center">
              <div class="form-group">
                <div class="input-group date" id="date" name="date">
                      <input class="form-control" type="text" readonly />
                      <div class="input-group-addon"> 
                        <span class="glyphicon glyphicon-calendar"></span> 
                      </div>
                </div>
              </div>
            </div>
            <div class="col-xs-2 col-sm-4 col-md-4 text-left">
              <a class="btn_bookingVCalender btn next-day"><span class="hidden-xs">Neste dag </span><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
          </div>
        </div>
      </div>
    <div class="row" id="calender-table">
    </div>
  </div>


  
  <!-- foreach
  <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    //hente alle bookings inni ett $room, for en gitt dato. sette inn verdi for neste dag, når dette blir valgt
    <table class="roomTable" data-toggle="modal" data-target="#myModal">
              <?php $range=range(strtotime("08:00"),strtotime("17:00"),30*60) ?>
              <?php $__currentLoopData = $range; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                // sette på booked hvis tabellen er booket
                <tr class="roomTr">
                  <th class="roomTd" id="firstTd">
                    <?php $date = date("H:i",$time); 
                    echo $date;?>
                  </th>
                  <td class="roomTd tdspacing" id="<?php echo e($date . ":00"); ?>" data-format="HH:mm" role="button"> 
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    -->
<div class="modal fade" id="booking_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<button class="bolle"> Tester </button>




    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Velg et tidspunkt</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" role="form" method="POST" action="/fargeklatt">
            <?php echo e(csrf_field()); ?>


              <div class="form-group">
                <label for="message-text" class="control-label">Dato</label>
                <div class="input-group date" id="date" name="date">
                  <input class="form-control dateString" type="text" name="dateString">
                  <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="message-text" class="control-label">Fra</label>
                  <div class='input-group date datetimepicker3'>
                    <input type='text' class="form-control datetimepicker3" data-format="HH:mm:ss" name="from"/>
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-time"></span>
                    </span>
                  </div>
              </div>

              <div class="form-group">
                <label for="message-text" class="control-label">Til</label>
                  <div class='input-group date datetimepicker3'>
                    <input type='text' class="form-control datetimepicker3" data-format="HH:mm:ss" name="to"/>
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-time"></span>
                    </span>
                  </div>
              </div>
              <div class="form-group">
                <label for="message-text" class="control-label"></label>
                  <div class='input-group date datetimepicker3'>
                    <input type='hidden' class="form-control datetimepicker3 room_id" data-format="HH:mm:ss" name="room_id"/>
                  </div>
              </div>
              <button type="submit button" class="btn btn-default save_booking"> Lagre </button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" class="close">Close</button>
        </div>
        </div>
        </div>
        </div>
  </body>
</html>