{{-- This form is used in both the show_member.blade.php and edit_member.blade.php --}}

<style>
    input[type="radio"]:checked ~ .reveal-if-active,
    input[type="checkbox"]:checked ~ .reveal-if-active {
    opacity: 1;
    max-height: 100px;
    overflow: visible;
    }
    .reveal-if-active {
    opacity: 0;
    max-height: 0;
    overflow: hidden;
    }

    .form-group.required .col-form-label:after {
    content:"*";
    color:red;
    }
</style>



<div class="form-group row required">
    <label for="position_id" class="col-md-4 col-form-label text-md-right">{{ __('Position') }}</label>
    <div class="col-md-6">
        <select id="position_id" name="position_id" class="form-control @error('position_id') is-invalid @enderror" value="{{ old('position_id') }}" autofocus  @isset($viewing) disabled @endisset>
            @foreach($positions as $position)
            <option value="{{ $position->id }}" {{ old( 'position_id', $member->position_id) == $position->id ? 'selected' : ''}}> {{ $position->position_name }}</option>
            @endforeach
        </select>
    </div>
    @error('position_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group row required">
    <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
    <div class="col-md-6">
        <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status') }}" autofocus @isset($viewing) disabled @endisset>
            <option value="Applicant" {{ old( 'status', $member->status) == 'Applicant' ? 'selected' : ''}} >Applicant</option>
            <option value="Approved" {{ old( 'status', $member->status) == 'Approved' ? 'selected' : ''}} >Approved</option>
            <option value="Active" {{ old( 'status', $member->status) == 'Active' ? 'selected' : ''}}>Active</option>
            <option value="Accepted" {{ old( 'status', $member->status) == 'Accepted' ? 'selected' : ''}}>Accepted</option>
            <option value="Abandoned" {{ old( 'status', $member->status) == 'Abandoned' ? 'selected' : ''}}>Abandoned</option>
            <option value="Inactive" {{ old( 'status', $member->status) == 'Inactive' ? 'selected' : ''}}>Inactive</option>
        </select>
    </div>
    @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>

<div class="form-group row required">
    <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

    <div class="col-md-6">
        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $member->first_name) }}" required autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('first_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="middle_name" class="col-md-4 col-form-label text-md-right">{{ __('Middle Name (Initial)') }}</label>

    <div class="col-md-6">
        <input id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name', $member->middle_name) }}" autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('middle_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row required">
    <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

    <div class="col-md-6">
        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $member->last_name) }}" required autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('last_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="preferred_name" class="col-md-4 col-form-label text-md-right">{{ __('Preferred Name') }}</label>

    <div class="col-md-6">
        <input id="preferred_name" type="text" class="form-control @error('preferred_name') is-invalid @enderror" name="preferred_name" value="{{ old('preferred_name', $member->preferred_name) }}"autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('preferred_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="father_name" class="col-md-4 col-form-label text-md-right">{{ __('Father\'s Name') }}</label>

    <div class="col-md-6">
        <input id="father_name" type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" value="{{ old('father_name', $member->father_name) }}" autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('father_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <input type="checkbox" id="father_senior_status" class="form-check-input @error('father_senior_status') is-invalid @enderror" name="father_senior_status" style="margin-left:10px" value="1" {{ old('father_senior_status', $member->father_senior_status) == '1' ? 'checked' : ''}} @isset($viewing) disabled @endisset>
        <label for="father_senior_status" class="form-check-label text-md-right" style="margin-left:30px">{{ __('Father is a Senior DeMolay') }}</label>
        <div class="col-md-12 reveal-if-active">
            <label for="father_senior_location" class="col-md-4 col-form-label">{{ __('Where?') }}</label>
            <input id="father_senior_location" type="text" class="col-md-12 form-control @error('father_senior_location') is-invalid @enderror" name="father_senior_location" value="{{ old('father_senior_location', $member->father_senior_location) }}" autofocus autocomplete="off" @isset($viewing) disabled @endisset>

            @error('father_senior_location')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <input type="checkbox" id="father_mason_status" class="form-check-input @error('father_mason_status') is-invalid @enderror" name="father_mason_status" style="margin-left:10px" value="1" @if($member->father_mason_status) checked @endif @isset($viewing) disabled @endisset>
        <label for="father_mason_status" class="form-check-label text-md-right" style="margin-left:30px">{{ __('Father is a Mason') }}</label>
        <div class="col-md-12 reveal-if-active">
            <label for="father_mason_location" class="col-md-4 col-form-label">{{ __('Where?') }}</label>
            <input id="father_mason_location" type="text" class="col-md-12 form-control @error('father_mason_location') is-invalid @enderror" name="father_mason_location" value="{{ old('father_mason_location', $member->father_mason_location) }}" autofocus autocomplete="off" @isset($viewing) disabled @endisset>

            @error('father_mason_location')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="mother_name" class="col-md-4 col-form-label text-md-right">{{ __('Mother\'s Name') }}</label>

    <div class="col-md-6">
        <input id="mother_name" type="text" class="form-control @error('mother_name') is-invalid @enderror" name="mother_name" value="{{ old('mother_name', $member->mother_name) }}" autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('mother_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <input id="mother_mason_other" type="text" class="form-control @error('mother_mason_other') is-invalid @enderror" name="mother_mason_other" value="{{ old('mother_mason_other', $member->mother_mason_other) }}" placeholder="Other Masonic" autofocus autocomplete="off" @isset($viewing) disabled @endisset>
        @error('mother_mason_other')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="guardian_one_name" class="col-md-4 col-form-label text-md-right">{{ __('Guardian\'s Name') }}</label>

    <div class="col-md-6">
        <input id="guardian_one_name" type="text" class="form-control @error('guardian_one_name') is-invalid @enderror" name="guardian_one_name" value="{{ old('guardian_one_name', $member->guardian_one_name) }}" autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('guardian_one_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <input type="checkbox" id="guardian_one_senior_status" class="form-check-input @error('guardian_one_senior_status') is-invalid @enderror" name="guardian_one_senior_status" style="margin-left:10px" value="1" {{ old('guardian_one_senior_status', $member->guardian_one_senior_status) == '1' ? 'checked' : ''}} @isset($viewing) disabled @endisset>
        <label for="guardian_one_senior_status" class="form-check-label text-md-right" style="margin-left:30px">{{ __('Guardian is a Senior Demolay') }}</label>
        <div class="col-md-12 reveal-if-active">
            <label for="guardian_one_senior_location" class="col-md-4 col-form-label">{{ __('Where?') }}</label>
            <input id="guardian_one_senior_location" type="text" class="col-md-12 form-control @error('guardian_one_senior_location') is-invalid @enderror" name="guardian_one_senior_location" value="{{ old('guardian_one_senior_location', $member->guardian_one_senior_location) }}" autofocus autocomplete="off" @isset($viewing) disabled @endisset>

            @error('guardian_one_senior_location')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <input type="checkbox" id="guardian_one_mason_status" class="form-check-input @error('guardian_one_mason_status') is-invalid @enderror" name="guardian_one_mason_status" style="margin-left:10px" value="1" {{ old('guardian_one_mason_status', $member->guardian_one_mason_status) == '1' ? 'checked' : ''}}  @isset($viewing) disabled @endisset>
        <label for="guardian_one_mason_status" class="form-check-label text-md-right" style="margin-left:30px">{{ __('Guardian is a Mason') }}</label>
        <div class="col-md-12 reveal-if-active">
            <label for="guardian_one_mason_location" class="col-md-4 col-form-label">{{ __('Where?') }}</label>
            <input id="guardian_one_mason_location" type="text" class="col-md-12 form-control @error('guardian_one_mason_location') is-invalid @enderror" name="guardian_one_mason_location" value="{{ old('guardian_one_mason_location, $member->guardian_one_mason_location') }}" autofocus autocomplete="off" @isset($viewing) disabled @endisset>

            @error('guardian_one_mason_location')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <input id="guardian_one_mason_other" type="text" class="form-control @error('guardian_one_mason_other') is-invalid @enderror" name="guardian_one_mason_other" value="{{ old('guardian_one_mason_other, $member->guardian_one_mason_other') }}" placeholder="Other Masonic" autofocus autocomplete="off" @isset($viewing) disabled @endisset>
        @error('guardian_one_mason_other')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="guardian_two_name" class="col-md-4 col-form-label text-md-right">{{ __('Guardian\'s Name') }}</label>

    <div class="col-md-6">
        <input id="guardian_two_name" type="text" class="form-control @error('guardian_two_name') is-invalid @enderror" name="guardian_two_name" value="{{ old('guardian_two_name', $member->guardian_two_name) }}" autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('guardian_two_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <input type="checkbox" id="guardian_two_senior_status" class="form-check-input @error('guardian_two_senior_status') is-invalid @enderror" name="guardian_two_senior_status" style="margin-left:10px" value="1" {{ old('guardian_two_senior_status', $member->guardian_two_senior_status) == '1' ? 'checked' : ''}} @isset($viewing) disabled @endisset>
        <label for="guardian_two_senior_status" class="form-check-label text-md-right" style="margin-left:30px">{{ __('Guardian is a Senior Demolay') }}</label>
        <div class="col-md-12 reveal-if-active">
            <label for="guardian_two_senior_location" class="col-md-4 col-form-label">{{ __('Where?') }}</label>
            <input id="guardian_two_senior_location" type="text" class="col-md-12 form-control @error('guardian_two_senior_location') is-invalid @enderror" name="guardian_two_senior_location" value="{{ old('guardian_two_senior_location', $member->guardian_two_senior_location) }}" autofocus autocomplete="off" @isset($viewing) disabled @endisset>

            @error('guardian_two_senior_location')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <input type="checkbox" id="guardian_two_mason_status" class="form-check-input @error('guardian_two_mason_status') is-invalid @enderror" name="guardian_two_mason_status" style="margin-left:10px" value="1" {{ old('guardian_two_mason_status', $member->guardian_two_mason_status) == '1' ? 'checked' : ''}} @isset($viewing) disabled @endisset>
        <label for="guardian_two_mason_status" class="form-check-label text-md-right" style="margin-left:30px">{{ __('Guardian is a Mason') }}</label>
        <div class="col-md-12 reveal-if-active">
            <label for="guardian_two_mason_location" class="col-md-4 col-form-label">{{ __('Where?') }}</label>
            <input id="guardian_two_mason_location" type="text" class="col-md-12 form-control @error('guardian_two_mason_location') is-invalid @enderror" name="guardian_two_mason_location" value="{{ old('guardian_two_mason_location', $member->guardian_two_mason_location) }}" autofocus autocomplete="off" @isset($viewing) disabled @endisset>

            @error('guardian_two_mason_location')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <input id="guardian_two_mason_other" type="text" class="form-control @error('guardian_two_mason_other') is-invalid @enderror" name="guardian_two_mason_other" value="{{ old('guardian_two_mason_other', $member->guardian_two_mason_other) }}" placeholder="Other Masonic" autofocus autocomplete="off" @isset($viewing) disabled @endisset>
        @error('guardian_two_mason_other')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row required">
    <label for="birthdate" class="col-md-4 col-form-label text-md-right">{{ __('Birthdate') }}</label>

    <div class="col-md-6">
        <input id="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ old('birthdate', $member->birthdate) }}" required autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('birthdate')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row required">
    <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>

    <div class="col-md-6">
        <select id="country" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country') }}" required autofocus @isset($viewing) disabled @endisset>
            <option value="">Choose a country</option>
            <option value="Canada" {{ old( 'country', $member->country) == 'Canada' ? 'selected' : ''}} >Canada</option>
        </select>
        @error('country')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row required">
    <label for="province" class="col-md-4 col-form-label text-md-right">{{ __('Province') }}</label>

    <div class="col-md-6">
        <select id="province" name="province" class="form-control @error('province') is-invalid @enderror" value="{{ old('province') }}" required autofocus @isset($viewing) disabled @endisset>
            <option value="">Choose a province</option>
            <option value="AB" {{ old('province', $member->province) == 'AB' ? 'selected' : ''}} >Alberta</option>
            <option value="BC" {{ old('province', $member->province) == 'BC' ? 'selected' : ''}}>British Columbia</option>
            <option value="SK" {{ old('province', $member->province) == 'SK' ? 'selected' : ''}}>Saskatchewan</option>
            <option value="MB" {{ old('province', $member->province) == 'MB' ? 'selected' : ''}}>Manitoba</option>
            <option value="ON" {{ old('province', $member->province) == 'ON' ? 'selected' : ''}}>Ontario</option>
            <option value="QC" {{ old('province', $member->province) == 'QC' ? 'selected' : ''}}>Quebec</option>
        </select>
        @error('province')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row required">
    <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

    <div class="col-md-6">
        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city', $member->city) }}" required autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('city')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row required">
    <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

    <div class="col-md-6">
        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $member->address) }}" required autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row required">
    <label for="postal_code" class="col-md-4 col-form-label text-md-right">{{ __('Postal Code') }}</label>

    <div class="col-md-6">
        <input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code', $member->postal_code) }}" placeholder="Eg. A1A 1A1" required autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('postal_code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row required">
    <label for="jurisdiction_id" class="col-md-4 col-form-label text-md-right">{{ __('Jurisdiction') }}</label>

    <div class="col-md-6">
        <select id="jurisdiction_id" name="jurisdiction_id" class="form-control @error('jurisdiction_id') is-invalid @enderror" value="{{ old('jurisdiction_id') }}" required autofocus @isset($viewing) disabled @endisset>
            <option value="">Choose a jurisdiction</option>
            @foreach($jurisdictions as $jurisdiction)
            <option value="{{ $jurisdiction->id }}" {{ old('jurisdiction_id', $member->jurisdiction_id) == $jurisdiction->id ? 'selected' : ''}}> {{ $jurisdiction->description }}</option>
            @endforeach
        </select>
        @error('jurisdiction_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row required">
    <label for="chapter_id" class="col-md-4 col-form-label text-md-right">{{ __('Chapter ID') }}</label>

    <div class="col-md-6">
        <select id="chapter_id" name="chapter_id" class="form-control @error('chapter_id') is-invalid @enderror" value="{{ old('chapter_id') }}" required autofocus @isset($viewing) disabled @endisset>
            <option value="">Choose a chapter</option>
                @foreach($chapters as $chapter)
                @if(isset($viewing))
                    <option value="{{ $chapter->id }}" selected> {{ $chapter->description }} </option>
                @endif
                @endforeach
        </select>

        @error('chapter_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row required">
    <label for="home_phone" class="col-md-4 col-form-label text-md-right">{{ __('Home Phone Number') }}</label>

    <div class="col-md-6">
        <input id="home_phone" type="text" class="form-control @error('home_phone') is-invalid @enderror" name="home_phone" value="{{ old('home_phone', $member->home_phone) }}" placeholder="Eg. 123-456-7890" required autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('home_phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="mobile_phone" class="col-md-4 col-form-label text-md-right">{{ __('Mobile Phone Number') }}</label>

    <div class="col-md-6">
        <input id="mobile_phone" type="text" class="form-control @error('mobile_phone') is-invalid @enderror" name="mobile_phone" value="{{ old('mobile_phone', $member->mobile_phone) }}" placeholder="Eg. 123-456-7890" autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('mobile_phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="work_phone" class="col-md-4 col-form-label text-md-right">{{ __('Work Phone Number') }}</label>

    <div class="col-md-6">
        <input id="work_phone" type="text" class="form-control @error('work_phone') is-invalid @enderror" name="work_phone" value="{{ old('work_phone', $member->work_phone) }}" placeholder="Eg. 123-456-7890" autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('work_phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row required">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

    <div class="col-md-6">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $member->email) }}" required autocomplete="off" @isset($viewing) disabled @endisset>

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row required">
    <label for="sponsor_id" class="col-md-4 col-form-label text-md-right">{{ __('DeMolay Sponsor ID') }}</label>

    <div class="col-md-6">
        <input id="sponsor_id" type="text" class="form-control @error('sponsor_id') is-invalid @enderror" name="sponsor_id" value="{{ old('sponsor_id', $member->sponsor_id) }}" required autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('sponsor_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row required">
    <label for="sponsor_name" class="col-md-4 col-form-label text-md-right">{{ __('DeMolay Sponsor Name') }}</label>

    <div class="col-md-6">
        <input id="sponsor_name" type="text" class="form-control @error('sponsor_name') is-invalid @enderror" name="sponsor_name" value="{{ old('sponsor_name', $member->sponsor_name) }}" required autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('sponsor_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="initiatory_date" class="col-md-4 col-form-label text-md-right">{{ __('Initiatory Degree Date') }}</label>

    <div class="col-md-6">
        <input id="initiatory_date" type="date" class="form-control @error('initiatory_date') is-invalid @enderror" name="initiatory_date" value="{{ old('initiatory_date', $member->initiatory_date) }}"autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('initiatory_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="demolay_degree_date" class="col-md-4 col-form-label text-md-right">{{ __('DeMolay Degree Date') }}</label>

    <div class="col-md-6">
        <input id="demolay_degree_date" type="date" class="form-control @error('demolay_degree_date') is-invalid @enderror" name="demolay_degree_date" value="{{ old('demolay_degree_date', $member->demolay_degree_date) }}"autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('demolay_degree_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="senior_demolay_date" class="col-md-4 col-form-label text-md-right">{{ __('Senior DeMolay Date') }}</label>

    <div class="col-md-6">
        <input id="senior_demolay_date" type="date" class="form-control @error('senior_demolay_date') is-invalid @enderror" name="senior_demolay_date" value="{{ old('senior_demolay_date', $member->senior_demolay_date) }}"autofocus autocomplete="off" @isset($viewing) disabled @endisset>

        @error('senior_demolay_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="notes" class="col-md-4 col-form-label text-md-right">{{ __('Notes') }}</label>

    <div class="col-md-6">
        <textarea id="notes" type="date" class="form-control @error('notes') is-invalid @enderror" name="notes" autofocus autocomplete="off" @isset($viewing) disabled @endisset>{{ old('notes', $member->notes) }}</textarea>

        @error('notes')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>