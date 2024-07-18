<?php

namespace App\Http\Livewire\Admin\Participants;

use App\Models\Participants;
use Livewire\Component;

class Single extends Component
{

    public $participants;

    public function mount(Participants $Participants){
        $this->participants = $Participants;
    }

    public function delete()
    {
        $this->participants->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Participants') ]) ]);
        $this->emit('participantsDeleted');
    }

    public function render()
    {
        return view('livewire.admin.participants.single')
            ->layout('admin::layouts.app');
    }
}
