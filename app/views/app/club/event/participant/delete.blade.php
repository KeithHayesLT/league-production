@extends('layouts.club')
@section('style')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="row">
        <div class="col-sm-5">
          <h3>Confirmation, are you sure?</h3>
          <p>We will remove this participant permanatly, this action cannot be reverse.</p>

          <p>
            <b>Player:</b> {{$player->firstname}} {{$player->lastname}} <br>
            <b>Event:</b> {{$participant->event->name}}
          </p>
          <br>
          {{Form::open(array('action' => array('ParticipantController@destroy', $participant->id), 'class'=>'form-horizontal', 'method' => 'post')) }}
          <div class="row">
            <div class="col-xs-12">
              <hr />
              <div class="form-group">
                <div class="col-sm-12">
                  <button type="submit" class="btn btn-danger btn-outline">Delete Participant</button>
                  <a href="{{URL::action('EventoController@index')}}" class="btn btn-primary btn-outline">Cancel</a>
                </div>
              </div>
            </div>
          </div> 
          {{Form::close()}}
        </div>
        <div class="col-sm-7">
        </div><!-- end of col-sm-7 row -->
      </div><!-- end of first row -->
      <br>
      <div class="row">
        <div class="col-md-12">
        </div>
      </div>
    </div>
  </div>
</div>
@stop
@section('script')
<script type="text/javascript">

$(function () {

  $(".dollar").kendoNumericTextBox({
    format: "c",
    decimals: 2
  });


});
</script>
@stop
