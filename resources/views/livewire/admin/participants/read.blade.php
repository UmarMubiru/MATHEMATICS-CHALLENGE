<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title">{{ __('ListTitle', ['name' => __(\Illuminate\Support\Str::plural('Participants')) ]) }}</h3>

                <div class="px-2 mt-4">

                    <ul class="breadcrumb mt-3 py-3 px-4 rounded">
                        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __(\Illuminate\Support\Str::plural('Participants')) }}</li>
                    </ul>

                    <div class="row justify-content-between mt-4 mb-4">

                        @if(getCrudConfig('Participants')->searchable())
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
                            <th scope="col" style='cursor: pointer' wire:click="sort('username')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'username') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'username') fa-sort-amount-up ml-2 @endif'></i> {{ __('Username') }} </th>
                            <th scope="col" style='cursor: pointer' wire:click="sort('firstname')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'firstname') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'firstname') fa-sort-amount-up ml-2 @endif'></i> {{ __('Firstname') }} </th>
                            <th scope="col" style='cursor: pointer' wire:click="sort('lastname')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'lastname') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'lastname') fa-sort-amount-up ml-2 @endif'></i> {{ __('Lastname') }} </th>
                            <th scope="col" style='cursor: pointer' wire:click="sort('emailAddress')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'emailAddress') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'emailAddress') fa-sort-amount-up ml-2 @endif'></i> {{ __('EmailAddress') }} </th>
                            <th scope="col" style='cursor: pointer' wire:click="sort('dateOfBirth')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'dateOfBirth') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'dateOfBirth') fa-sort-amount-up ml-2 @endif'></i> {{ __('DateOfBirth') }} </th>
                            <th scope="col" style='cursor: pointer' wire:click="sort('schoolRegistrationNumber')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'schoolRegistrationNumber') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'schoolRegistrationNumber') fa-sort-amount-up ml-2 @endif'></i> {{ __('SchoolRegistrationNumber') }} </th>
                            <th scope="col" style='cursor: pointer' wire:click="sort('imageFile')"> <i class='fa @if($sortType == 'desc' and $sortColumn == 'imageFile') fa-sort-amount-down ml-2 @elseif($sortType == 'asc' and $sortColumn == 'imageFile') fa-sort-amount-up ml-2 @endif'></i> {{ __('ImageFile') }} </th>

                            @if(getCrudConfig('Participants')->delete or getCrudConfig('Participants')->update)
                                <th scope="col">{{ __('Action') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participantss as $participants)
                            @livewire('admin.participants.single', [$participants], key($participants->id))
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-auto pt-3 pr-3">
                {{ $participantss->appends(request()->query())->links() }}
            </div>

            <div wire:loading wire:target="nextPage,gotoPage,previousPage" class="loader-page"></div>

        </div>
    </div>
</div>
