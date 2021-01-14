@extends('layouts.app')


@section('content')

<body>
    <div class="container">
        <div class="col-sm-12">

            @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h1 style="padding-bottom: 23px;" class="display-6 text-center">Contact Us</h1>
                @if(Auth::user() == null)
                @elseif(!Auth::user()->hasRole('Admin'))
                @else
                <div>
                    <a style="margin: 9px;" href="{{ route('contacts.create')}}" class="btn btn-primary">New contact</a>
                </div>
                @endif
                <table class="table table-striped">
                    <thead>
                        
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                        <tr>
                            <td style="display: none;">{{$contact->id}}</td>
                            <td>{{$contact->name}}</td>
                            <td><a href="mailto:{{$contact->email}}" target="_blank">{{$contact->email}}</a></td>
                            <td><a href="{{$contact->url}}" target="_blank">{{$contact->url}}</a></td>
                            @if(Auth::user() == null)
                            @elseif(!Auth::user()->hasRole('Admin'))
                            @else
                            <td>
                                <a href="{{ route('contacts.edit',$contact->id)}}" class="btn btn-primary">Edit</a>
                            </td>
                            <td>
                                <form action="{{ route('contacts.destroy', $contact->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                </div>
                @endsection
            </div>
</body>