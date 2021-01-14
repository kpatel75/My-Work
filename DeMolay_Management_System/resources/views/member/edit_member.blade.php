@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Edit Member') }}</div>
                @if ($errors->any()) 
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif
                <div class="col-md" style="margin-top:10px">
                    <a href="/memberprofile/{{ $member->id }}" class="btn btn-secondary align-self-start">Back</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="/memberprofile/{{ $member->id }}/show" autocomplete="off">
                        @method('PATCH')
                        @csrf
                        {{-- The actual form can be found in the edit_form.blade.php file. will affect both edit_member and show_member --}}
                        @include('member.edit_form')
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to save these changes?')">
                                    {{ __('Save Changes') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function() {
    $('#jurisdiction_id').change(function() { 
        var $chapter = $('#chapter_id'); 
        var $jur = document.getElementById('jurisdiction_id').value;
        $.ajax({
                url: "{{ route('getchapters') }}/" + $jur,
                success: function(data) { 
                    console.log(data);
                    $chapter.html('<option id="chapter-none" value="">Choose a chapter</option>');
                    $.each(data, function(id, value) {
                        $chapter.append('<option value="'+id+'">'+value+'</option>'); 
                        console.log(id);
                    });
                    $('#chapter_id').show(150);
                }
    }); 
    }).change(); 
    
    });
   </script>
@endsection
