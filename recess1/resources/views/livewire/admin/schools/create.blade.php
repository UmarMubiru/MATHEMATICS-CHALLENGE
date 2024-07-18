<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">{{ __('CreateTitle', ['name' => __('Schools') ]) }}</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.schools.read')" class="text-decoration-none">{{ __(\Illuminate\Support\Str::plural('Schools')) }}</a></li>
                <li class="breadcrumb-item active">{{ __('Create') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="create" enctype="multipart/form-data">

        <div class="card-body">
                        <!-- Name Input -->
            <div class='form-group'>
                <label for='input-name' class='col-sm-2 control-label '> {{ __('Name') }}</label>
                <input type='text' id='input-name' wire:model.lazy='name' class="form-control  @error('name') is-invalid @enderror" placeholder='' autocomplete='on'>
                @error('name') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            <!-- District Input -->
            <div class='form-group'>
                <label for='input-district' class='col-sm-2 control-label '> {{ __('District') }}</label>
                <input type='text' id='input-district' wire:model.lazy='district' class="form-control  @error('district') is-invalid @enderror" placeholder='' autocomplete='on'>
                @error('district') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            <!-- Registration_number Input -->
            <div class='form-group'>
                <label for='input-registration_number' class='col-sm-2 control-label '> {{ __('Registration_number') }}</label>
                <input type='text' id='input-registration_number' wire:model.lazy='registration_number' class="form-control  @error('registration_number') is-invalid @enderror" placeholder='' autocomplete='on'>
                @error('registration_number') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            <!-- Email Input -->
            <div class='form-group'>
                <label for='input-email' class='col-sm-2 control-label '> {{ __('Email') }}</label>
                <input type='email' id='input-email' wire:model.lazy='email' class="form-control  @error('email') is-invalid @enderror" placeholder='' autocomplete='on'>
                @error('email') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            <!-- Representative Input -->
            <div class='form-group'>
                <label for='input-representative' class='col-sm-2 control-label '> {{ __('Representative') }}</label>
                <input type='text' id='input-representative' wire:model.lazy='representative' class="form-control  @error('representative') is-invalid @enderror" placeholder='' autocomplete='on'>
                @error('representative') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Create') }}</button>
            <a href="@route(getRouteName().'.schools.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
