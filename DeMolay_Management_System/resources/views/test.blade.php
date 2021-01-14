@extends('layouts.app')

@section('content')
<script>
var test = <?php echo $test; ?>;
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @guest
            
        @else
            <h1>Welcome, {{ Auth::user()->name }}</h1>
        @endguest
        <h1>This page is accessable by admin</h1>
        </div>
    </div>
    <h2>{{ $test }}</h2>
</div>
@endsection