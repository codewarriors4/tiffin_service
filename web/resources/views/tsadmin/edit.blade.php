@extends('tsadmin.master')

@section('pageheader')
    Edit User
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

        {!! Form::Open(array("method"=>"post", "id"=>"updateUser", 'route'=>array('updateuser',$config->id) )) !!}

          <div class="panel panel-primary">
              <div class="panel-heading">Edit Link</div>
              <div class="panel-body">
                <div class="form-group row">
                    <div class="col-sm-2"> {!! Form::label('UserPhone','Phone') !!}  </div>
                    <div class="col-sm-8 "> {!! Form::text('UserPhone',$config->UserPhone,['class'=>'form-control']) !!}
                      {!!$errors->first('UserPhone','<span class="error_text">:message</span>')!!}
                    </div>
                </div>

                  <div class="form-group row">
                    <div class="col-sm-2"> {!! Form::label('Street','Street') !!}  </div>
                    <div class="col-sm-8 "> {!! Form::text('UserStreet',$config->UserStreet,['class'=>'form-control']) !!}
                         {!!$errors->first('UserStreet','<span class="error_text">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-2"> {!! Form::label('UserProvince','Province') !!}  </div>
                    <div class="col-sm-8 "> 
                    <select name="UserProvince">
                    @foreach ($provinces as $key => $province)

                      @if ($province == $config->UserProvince)
                        <option value="{{ $config->UserProvince }}" selected>{{ $config->UserProvince }}</option>
                      @else
                        <option value="{{ $province }}">{{ $province }}</option>
                      @endif


                    @endforeach
                         
                    </select>
                 
                    </div>
                </div>

                            <div class="form-group row">
                    <div class="col-sm-2"> {!! Form::label('UserCity','City') !!}  </div>
                    <div class="col-sm-8 "> {!! Form::text('UserCity',$config->UserCity,['class'=>'form-control']) !!}
                         {!!$errors->first('UserCity','<span class="error_text">:message</span>') !!}
                    </div>
                </div>

                            <div class="form-group row">
                    <div class="col-sm-2"> {!! Form::label('UserZipCode','Postal Code') !!}  </div>
                    <div class="col-sm-8 "> {!! Form::text('UserZipCode',$config->UserZipCode,['class'=>'form-control']) !!}
                         {!!$errors->first('UserZipCode','<span class="error_text">:message</span>') !!}
                    </div>
                </div>


                <div class="row ">
                       {!! Form::submit('Update',array('class'=>'btn btn-primary','style'=>'margin:10px')) !!}
                      <a class="btn btn-danger" href="{{ URL::route('manageusers') }}">Cancel</a>
                </div>

             </div>
        </div>



        {!! Form::Close() !!}

</div>


@stop
