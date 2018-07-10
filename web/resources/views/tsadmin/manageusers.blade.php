@extends('tsadmin.master')

@section('pageheader')
Manage Users
@stop



@section('content')
<br/>

@if(Session::has('message'))
    <div class="alert alert-success alert-dismissible">
        {{Session::get('message')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="container-fluid">

	<div class="row">
		<div class="col-md-3">

		</div>



    </div>

    <div class="box">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><input id="select_all"  name="select_all" type = "checkbox" name="selectuser" onChange="select_all(this)" />
                    </th>                 
                    <th>Email
                        
                    </th>
                    <th>First Name
                     
                    </th>
                    <th>Last Name
                     
                    </th>

                    <th>Approved ?
                        
                    </th>
                    
                    <th class="center">Actions</th>
                </tr>
            </thead>
            <tbody>



            @foreach($users as $user)
            
                <tr id="{{ $user->UserId }}">
                 
                    <td></td>       
                         
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->UserFname }}</td>
                    <td>{{ $user->UserLname }}</td>
                    <td>{{($user->isActive==1)?'Yes':'No'}}</td>

                    <td class="center">
                    <a target="_blank" href="{{ URL::to('/').'/registry/'.$user->UserCustomURL }}" class="btn
                    btn-primary
                    custom-width" >View</a>
                    @if(!(Auth::id()== $user->UserId))
                            @if($user->UserAccountBlocked==0)
                            <button id ="{{$user->UserId}}" class="btn btn-primary custom-width" value="sdasdasd" onclick="modify_request({{$user->UserId}},'block',this)">{{($user->UserAccountBlocked==0)?'Block':'Unblock'}}</button>
                            @else
                            <button id ="{{$user->UserId}}" class="btn btn-primary custom-width" value="sdasdasd" onclick="modify_request({{$user->UserId}},'unblock',this)">{{($user->UserAccountBlocked==0)?'Block':'Unblock'}}</button>
                            @endif
                            <button id ="{{$user->UserId}}"  class="btn btn-danger custom-width" onclick="modify_request({{$user->UserId}},'delete',this)" >Delete</button>
                       @endif 
                    </td>                   
                   
                </tr>
                
            @endforeach
           
            </tbody>
        </table>
         
    </div>

    @if(($users->count())<1)
              <h4><b> No Records Found</b></h4> 
            @endif


@stop
