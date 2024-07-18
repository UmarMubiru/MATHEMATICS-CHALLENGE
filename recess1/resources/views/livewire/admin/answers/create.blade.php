<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">{{ __('CreateTitle', ['name' => __('Answers') ]) }}</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.answers.read')" class="text-decoration-none">{{ __(\Illuminate\Support\Str::plural('Answers')) }}</a></li>
                <li class="breadcrumb-item active">{{ __('Create') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="create" enctype="multipart/form-data">

        <div class="card-body">
                        <!-- Answers Input -->
            <div class='form-group'>
                <label for='input-answers' class='col-sm-2 control-label '> {{ __('Answers') }}</label>
                <input type='file' id='input-answers' wire:model='answers' class="form-control-file  @error('answers') is-invalid @enderror">
                @if($answers and !$errors->has('answers') and $answers instanceof Illuminate\Http\UploadedFile and $answers->isPreviewable())
                    <a href="{{ $answers->temporaryUrl() }}" target="_blank"><img width="200" height="200" class="mt-3 img-fluid shadow" src="{{ $answers->temporaryUrl() }}" alt=""></a>
                @endif
                @error('answers') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Create') }}</button>
            <a href="@route(getRouteName().'.answers.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
