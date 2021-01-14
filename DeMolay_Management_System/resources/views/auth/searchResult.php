@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><strong>Search Member</strong></div>

                </div>

            <table class="table table-stiped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                    <tr>
                        <th scope="row">{{$member->memberid}}</th>
                        <td>{{$member->firstName}}</td>
                        <td>{{$member->lastName}}</td>
                        <td>{{$member->email}}</td>
                        <td style="display: flex;">
                        <div>
                            <a href="#" class="btn btn-primary mr-2">Edit</a>
                        </div>
                        <form action="#" method="post">
                            {{ method_feild('DELETE')}}
                            @csrf
                            <button class="btn btn-danger"  type="submit">Delete</button>
                        </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection