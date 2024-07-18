<tr x-data="{ modalIsOpen : false }">
    <td class="">{{ $schools->name }}</td>
    <td class="">{{ $schools->district }}</td>
    <td class="">{{ $schools->registration_number }}</td>
    <td class="">{{ $schools->email }}</td>
    <td class="">{{ $schools->representative }}</td>
    
    @if(getCrudConfig('Schools')->delete or getCrudConfig('Schools')->update)
        <td>

            @if(getCrudConfig('Schools')->update && hasPermission(getRouteName().'.schools.update', 0, 0, $schools))
                <a href="@route(getRouteName().'.schools.update', $schools->id)" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif

            @if(getCrudConfig('Schools')->delete && hasPermission(getRouteName().'.schools.delete', 0, 0, $schools))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('Schools') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('Schools') ]) }}</p>
                        <div class="mt-5 d-flex justify-content-between">
                            <a wire:click.prevent="delete" class="text-white btn btn-success shadow">{{ __('Yes, Delete it.') }}</a>
                            <a @click.prevent="modalIsOpen = false" class="text-white btn btn-danger shadow">{{ __('No, Cancel it.') }}</a>
                        </div>
                    </div>
                </div>
            @endif
        </td>
    @endif
</tr>
