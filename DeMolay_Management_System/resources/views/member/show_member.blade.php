@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('View member') }}</div>
                @if (isset($success))
                    <div class="alert alert-success">
                        {{ $success }}
                    </div>
                @endif
                <div class="col-md" style="margin-top:10px">
                    <a href="/memberprofile/{{ $member->id }}" class="btn btn-secondary align-self-start">Back</a>
                </div>
                @php
                    $viewing = 1;
                @endphp
                <div class="card-body">
                    <form method="" action="/memberprofile/{{ $member->id }}/edit">
                        @csrf
                        {{-- The actual form can be found in the edit_form.blade.php file. will affect both edit_member and show_member --}}
                        @include('member.edit_form')
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edit Member') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
