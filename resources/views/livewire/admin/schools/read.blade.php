
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">{{ __('ListTitle', ['name' => __(\Illuminate\Support\Str::plural('Schools')) ]) }}</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __(\Illuminate\Support\Str::plural('Schools')) }}</li>
                    </ul>

                    <div class="row justify-content-between mt-4 mb-4">
                        @if(getCrudConfig('Schools')->create && hasPermission(getRouteName().'.schools.create', 0, 0))
                        <div class="col-md-4 right-0">
                            <a href="@route(getRouteName().'.schools.create')" class="btn btn-success">{{ __('CreateTitle', ['name' => __('Schools') ]) }}</a>
                        </div>
                        @endif
                        @if(getCrudConfig('Schools')->searchable())
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" @if(config('easy_panel.lazy_mode')) wire:model.lazy="search" @else wire:model="search" @endif placeholder="{{ __('Search') }}" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-default">
                                        <a wire:target="search" wire:loading.remove><i class="fa fa-search"></i></a>
                                        <a wire:loading wire:target="search"><i class="fas fa-spinner fa-spin" ></i></a>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col" style='cursor: pointer' wire:click="sort('name')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'name') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'name') fa-sort-amount-up ml-2 @endif'></i> {{ __('Name') }} </th>
                            <th scope="col" style='cursor: pointer' wire:click="sort('district')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'district') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'district') fa-sort-amount-up ml-2 @endif'></i> {{ __('District') }} </th>
                            <th scope="col" style='cursor: pointer' wire:click="sort('registration_number')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'registration_number') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'registration_number') fa-sort-amount-up ml-2 @endif'></i> {{ __('Registration_number') }} </th>
                            <th scope="col" style='cursor: pointer' wire:click="sort('email')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'email') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'email') fa-sort-amount-up ml-2 @endif'></i> {{ __('Email') }} </th>
                            <th scope="col" style='cursor: pointer' wire:click="sort('representative')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'representative') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'representative') fa-sort-amount-up ml-2 @endif'></i> {{ __('Representative') }} </th>

                            @if(getCrudConfig('Schools')->delete or getCrudConfig('Schools')->update)
                                <th scope="col">{{ __('Action') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schoolss as $schools)
                            @livewire('admin.schools.single', [$schools], key($schools->id))
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $schoolss->appends(request()->query())->links() }}
            </div>

            <div wire:loading wire:target="nextPage,gotoPage,previousPage" class="loader-page"></div>

        </div>
    </div>
</div>

