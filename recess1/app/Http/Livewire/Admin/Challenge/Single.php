<?php

namespace App\Http\Livewire\Admin\Challenge;

use App\Models\Challenge;
use Livewire\Component;

class Single extends Component
{

    public $challenge;

    public function mount(Challenge $Challenge){
        $this->challenge = $Challenge;
    }

    public function delete()
    {
        $this->challenge->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Challenge') ]) ]);
        $this->emit('challengeDeleted');
    }

    public function render()
    {
        return view('livewire.admin.challenge.single')
            ->layout('admin::layouts.app');
    }
}
