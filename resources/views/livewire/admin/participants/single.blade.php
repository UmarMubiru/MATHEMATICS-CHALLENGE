<tr x-data="{ modalIsOpen : false }">
    <td class="">{{ $participants->username }}</td>
    <td class="">{{ $participants->firstname }}</td>
    <td class="">{{ $participants->lastname }}</td>
    <td class="">{{ $participants->emailAddress }}</td>
    <td class="">{{ $participants->dateOfBirth }}</td>
    <td class="">{{ $participants->schoolRegistrationNumber }}</td>
    <td class="">{{ $participants->imageFile }}</td>
    
    @if(getCrudConfig('Participants')->delete or getCrudConfig('Participants')->update)
        <td>

            @if(getCrudConfig('Participants')->update && hasPermission(getRouteName().'.participants.update', 0, 0, $participants))
                <a href="@route(getRouteName().'.participants.update', $participants->id)" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif

            @if(getCrudConfig('Participants')->delete && hasPermission(getRouteName().'.participants.delete', 0, 0, $participants))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('Participants') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('Participants') ]) }}</p>
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
