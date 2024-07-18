<div class="card">
    <div class="card-header p-0">
        <h3 class="card-title">{{ __('CreateTitle', ['name' => __('Questions') ]) }}</h3>
        <div class="px-2 mt-4">
            <ul class="breadcrumb mt-3 py-3 px-4 rounded">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.questions.read')" class="text-decoration-none">{{ __(\Illuminate\Support\Str::plural('Questions')) }}</a></li>
                <li class="breadcrumb-item active">{{ __('Create') }}</li>
            </ul>
        </div>
    </div>

    <form class="form-horizontal" wire:submit.prevent="create" enctype="multipart/form-data">

        <div class="card-body">
                        <!-- Questions Input -->
            <div class='form-group'>
                <label for='input-questions' class='col-sm-2 control-label '> {{ __('Questions') }}</label>
                <input type='file' id='input-questions' wire:model='questions' class="form-control-file  @error('questions') is-invalid @enderror">
                @if($questions and !$errors->has('questions') and $questions instanceof Illuminate\Http\UploadedFile and $questions->isPreviewable())
                    <a href="{{ $questions->temporaryUrl() }}" target="_blank"><img width="200" height="200" class="mt-3 img-fluid shadow" src="{{ $questions->temporaryUrl() }}" alt=""></a>
                @endif
                @error('questions') <div class='invalid-feedback'>{{ $message }}</div> @enderror
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info ml-4">{{ __('Create') }}</button>
            <a href="@route(getRouteName().'.questions.read')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
