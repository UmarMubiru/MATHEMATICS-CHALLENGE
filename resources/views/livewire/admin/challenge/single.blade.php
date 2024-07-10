<tr x-data="{ modalIsOpen : false }">
    <td class="">{{ $challenge->name }}</td>
    <td class="">{{ $challenge->open_date }}</td>
    <td class="">{{ $challenge->close_date }}</td>
    <td class="">{{ $challenge->duration }}</td>
    <td class="">{{ $challenge->no_of_questions }}</td>
    
    @if(getCrudConfig('Challenge')->delete or getCrudConfig('Challenge')->update)
        <td>

            @if(getCrudConfig('Challenge')->update && hasPermission(getRouteName().'.challenge.update', 0, 0, $challenge))
                <a href="@route(getRouteName().'.challenge.update', $challenge->id)" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif

            @if(getCrudConfig('Challenge')->delete && hasPermission(getRouteName().'.challenge.delete', 0, 0, $challenge))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('Challenge') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('Challenge') ]) }}</p>
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
