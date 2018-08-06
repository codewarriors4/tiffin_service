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

                    <th>Email

                    </th>
                    <th>First Name

                    </th>
                    <th>Last Name

                    </th>

                     <th>User Type

                    </th>

                    <th>Approved ?

                    </th>

                    <th class="center">License</th>
                    <th class="center">License Expiry (yyyy-mm-dd)</th>
                     <th class="center">Approve</th>
                     <th class="center">Actions</th>
                </tr>
            </thead>
            <tbody>



            @foreach($users as $user)

                <tr id="{{ $user->UserId }}">

                    <td>{{ $user->email }}</td>
                    <td>{{ $user->UserFname }}</td>
                    <td>{{ $user->UserLname }}</td>

                    @if($user->UserType == 0)

                    <td>TiffinSeeker</td>

                    @elseif($user->UserType == 1)

                    <td>HomeMaker</td>


                    @elseif($user->UserType == 2)

                     <td>Admin</td>

                     @elseif($user->UserType == 3)

                     <td>Driver</td>                    

                     @endif  

                    <td>{{($user->isActive==1)?'Yes':'No'}}</td>


                    <td>

                     @if($user->license == 'NA' || $user->license == '' )
                                    <p>NA</p>
                                @else
                                   <a href="{{URL::to('/').$user->license}}">View</a>
                            @endif

                     </td>
                     <td>{{$user->HMLicenseExpiryDate}}</td>

                     <td class="center">

                            @if($user->isActive==0 && $user->UserType == 1 )s

                            <button id ="{{$user->id}}" class="btn btn-primary custom-width" value="sdasdasd" onclick="modify_request({{$user->id}})">Approve</button>
                            @endif
                    </td>

                   <td class="center">
                            <a href="{{URL::to('/admin/edit')."/".$user->id}}">Edit</a>
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
