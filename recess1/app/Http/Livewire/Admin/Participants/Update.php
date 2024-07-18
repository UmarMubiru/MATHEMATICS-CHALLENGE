<?php

namespace App\Http\Livewire\Admin\Participants;

use App\Models\Participants;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $participants;

    
    protected $rules = [
        
    ];

    public function mount(Participants $Participants){
        $this->participants = $Participants;
        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Participants') ]) ]);
        
        $this->participants->update([
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.participants.update', [
            'participants' => $this->participants
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Participants') ])]);
    }
}
