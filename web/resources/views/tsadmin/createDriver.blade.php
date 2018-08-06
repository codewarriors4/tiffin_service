@extends('tsadmin.master')

@section('pageheader')
  Create Driver
@stop

@section('content')
<br/>
<div class="container-fluid">

@if(Session::has('message'))
    <div class="alert alert-success fade">
      {{Session::get('message')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
    </div>
@endif

<div class="row">

        {!! Form::Open(array("method"=>"post", "id"=>"saveDriver", 'route'=>array('saveDriver') )) !!}

          <div class="panel panel-primary">
              <div class="panel-heading">Create Driver Details</div>
              <div class="panel-body">

                <div class="form-group row">
                    <div class="col-sm-2"> {!! Form::label('email','Email') !!}  </div>
                    <div class="col-sm-8 "> {!! Form::email('email',null,['class'=>'form-control','required'=>'true']) !!}
                      {!!$errors->first('email','<span class="error_text">:message</span>')!!}
                    </div>
                </div>



                <div class="form-group row">
                    <div class="col-sm-2"> {!! Form::label('UserFname','First Name') !!}  </div>
                    <div class="col-sm-8 "> {!! Form::text('UserFname',null,['class'=>'form-control','required'=>'true']) !!}
                      {!!$errors->first('UserFname','<span class="error_text">:message</span>')!!}
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-sm-2"> {!! Form::label('UserLname','Last Name') !!}  </div>
                    <div class="col-sm-8 "> {!! Form::text('UserLname',null,['class'=>'form-control','required'=>'true']) !!}
                      {!!$errors->first('UserLname','<span class="error_text">:message</span>')!!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-2"> {!! Form::label('UserPhone','Phone') !!}  </div>
                    <div class="col-sm-8 "> {!! Form::text('UserPhone',null,['class'=>'form-control','required'=>'true']) !!}
                      {!!$errors->first('UserPhone','<span class="error_text">:message</span>')!!}
                    </div>
                </div>

                  <div class="form-group row">
                    <div class="col-sm-2"> {!! Form::label('Street','Street') !!}  </div>
                    <div class="col-sm-8 "> {!! Form::text('UserStreet',null,['class'=>'form-control','required'=>'true']) !!}
                         {!!$errors->first('UserStreet','<span class="error_text">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-2"> {!! Form::label('UserProvince','Province') !!}  </div>
                    <div class="col-sm-8 "> 
                    <select name="UserProvince">
                    @foreach ($provinces as $key => $province)
             
                        <option value="{{ $province }}">{{ $province }}</option>


                    @endforeach
                         
                    </select>
                 
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-2"> {!! Form::label('UserCity','City') !!}  </div>
                    <div class="col-sm-8 "> {!! Form::text('UserCity',null,['class'=>'form-control','required'=>'true']) !!}
                         {!!$errors->first('UserCity','<span class="error_text">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-2"> {!! Form::label('UserZipCode','Postal Code') !!}  </div>
                    <div class="col-sm-8 "> {!! Form::text('UserZipCode',null,['class'=>'form-control','required'=>'true']) !!}
                         {!!$errors->first('UserZipCode','<span class="error_text">:message</span>') !!}
                    </div>
                </div>


                <div class="row ">
                       {!! Form::submit('Create',array('class'=>'btn btn-primary','style'=>'margin:10px')) !!}
                      <a class="btn btn-danger" href="{{ URL::route('manageusers') }}">Cancel</a>
                </div>

             </div>
        </div>



        {!! Form::Close() !!}

</div>


@stop
