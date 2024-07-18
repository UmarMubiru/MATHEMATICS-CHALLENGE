<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">{{ __('UpdateTitle', ['name' => __('Challenge') ]) }}</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.challenge.read')" class="text-decoration-none">{{ __(\Illuminate\Support\Str::plural('Challenge')) }}</a></li>
                <li class="breadcrumb-item active">{{ __('Update') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="update" enctype="multipart/form-data">

        <div class="card-body">

                        <!-- Name Input -->
            <div class='form-group'>
                <label for='input-name' class='col-sm-2 control-label '> {{ __('Name') }}</label>
                <input type='text' id='input-name' wire:model.lazy='name' class="form-control  @error('name') is-invalid @enderror" placeholder='' autocomplete='on'>
                @error('name') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            <!-- Open_date Input -->
            <div class='form-group'>
                <label for='input-open_date' class='col-sm-2 control-label '> {{ __('Open_date') }}</label>
                <input type='date' id='input-open_date' wire:model.lazy='open_date' class="form-control  @error('open_date') is-invalid @enderror" autocomplete='on'>
                @error('open_date') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            <!-- Close_date Input -->
            <div class='form-group'>
                <label for='input-close_date' class='col-sm-2 control-label '> {{ __('Close_date') }}</label>
                <input type='date' id='input-close_date' wire:model.lazy='close_date' class="form-control  @error('close_date') is-invalid @enderror" autocomplete='on'>
                @error('close_date') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            <!-- Duration Input -->
            <div class='form-group'>
                <label for='input-duration' class='col-sm-2 control-label '> {{ __('Duration') }}</label>
                <input type='number' id='input-duration' wire:model.lazy='duration' class="form-control  @error('duration') is-invalid @enderror" placeholder='' autocomplete='on'>
                @error('duration') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>
            <!-- No_of_questions Input -->
            <div class='form-group'>
                <label for='input-no_of_questions' class='col-sm-2 control-label '> {{ __('No_of_questions') }}</label>
                <input type='number' id='input-no_of_questions' wire:model.lazy='no_of_questions' class="form-control  @error('no_of_questions') is-invalid @enderror" placeholder='' autocomplete='on'>
                @error('no_of_questions') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>


        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Update') }}</button>
            <a href="@route(getRouteName().'.challenge.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
