<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
    
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
        format: 'DD dd/mm/yyyy',
        language: 'nb',
        todayHighlight: true,
      }).datepicker("setDate", new Date());

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
    });

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

    var rooms = {!! str_replace("'", "\'", json_encode($rooms)) !!};

    var bookings = {!! str_replace("'", "\'", json_encode($booking)) !!};

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

    for (var i = 0; i < rooms.length; i++) {
      var roomId = rooms[i]['id'];
      var table = '<div class="col-sm-5"><table class="roomTable" id=' + roomId + '>room '+ roomId +'</table></div>';
      $(table).appendTo('#calender-table');

      for(var j = 0; j < times.length; j++) {
        $('<tr class="roomTr"><th class="roomTd" id="firstTd">'+ times[j] +'</th><td role="button" class="roomTd tdspacing" data-toggle="modal" data-target="#myModal" id=' + (times[j]+':00') + '></td></tr>').appendTo('table#'+ roomId +'');
      }

    }

    //bookings[i]['room_id']

    // bookings[0]['room_id'] = 1
    // bookings[1]['room_id'] = 2
    // bookings[2]['room_id'] = 1

    //var tdsInTable = $('table#'+ '1' +'').find('td');

    for(var i = 0; i<bookings.length; i++) {

      var tdsInTable = $('table#'+ bookings[i]['room_id'] +'').find('td');

      for(var j = 0; j <tdsInTable.length; j++) {

        if (bookings[i]['from'] == tdsInTable[j].id) {
          $(tdsInTable[j]).append(bookings[i]['from']).attr('id', 'bookStart');
        } 
        else if (bookings[i]['to'] == tdsInTable[j].id) {
          $(tdsInTable[j-1]).append(bookings[i]['to']).attr('id', 'bookEnd').addClass('colorMe');
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

      }).addClass('colorMe booked');
    }

/*
    $('.test').click(function(e) {
      alert('hei');
      $(this).append('<p>hallo</p>');
    });*/

    $('.roomTable').click(function(e) {
      var tableID = this.getAttribute("id");
      $('.room_id').val(tableID);
    });


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

  <div class="container">
    <div class="row" id="calender-table">
    </div>
  </div>
  
  <!-- foreach
  @foreach($rooms as $room)
    //hente alle bookings inni ett $room, for en gitt dato. sette inn verdi for neste dag, når dette blir valgt
    <table class="roomTable" data-toggle="modal" data-target="#myModal">
              <?php $range=range(strtotime("08:00"),strtotime("17:00"),30*60) ?>
              @foreach($range as $time)
                // sette på booked hvis tabellen er booket
                <tr class="roomTr">
                  <th class="roomTd" id="firstTd">
                    <?php $date = date("H:i",$time); 
                    echo $date;?>
                  </th>
                  <td class="roomTd tdspacing" id="{{$date . ":00"}}" data-format="HH:mm" role="button"> 
                  </td>
                </tr>
                @endforeach
    </table>
@endforeach
    -->
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
            {{ csrf_field() }}

              <div class="form-group">
                <label for="message-text" class="control-label">Dato</label>
                <div class="input-group date" id="date" name="date">
                  <input class="form-control" type="text">
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
  </body>
</html>