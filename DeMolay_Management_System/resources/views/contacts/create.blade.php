@extends('layouts.app')


@section('content')

@if(Auth::user() == null)
@elseif(!Auth::user()->hasRole('Admin'))
<meta http-equiv = "refresh" content = " 0; url = {{ url('contacts')}}" />
@else

<body>
    <div class="container">
    <div class="row">
 <div class="col-sm-8 offset-sm-2">
    <h1 class="display-6 text-center">Add a Contact</h1>
    <p class="text-right"><span style="color:red;">*</span> indicates required feild</p>
  <div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('contacts.store') }}">
          @csrf
          <div class="form-group">    
              <label for="name">Name:<span style="color:red;">*</span></label>
              <input type="text" class="form-control" name="name"/>
          </div>
          <div class="form-group">
              <label for="email">Email:<span style="color:red;">*</span></label>
              <input type="text" class="form-control" name="email"/>
          </div>
          <div class="form-group">
              <label for="url">URL:</label>
              <input type="text" class="form-control" name="url"/>
          </div>
          <button type="submit" class="btn btn-primary">Add contact</button>
      </form>
  </div>
</div>
</div>
    </div>
</body>
@endif
@endsection