<?php

namespace App\Http\Livewire\Admin\Schools;

use App\Models\Schools;
use Livewire\Component;

class Single extends Component
{

    public $schools;

    public function mount(Schools $Schools){
        $this->schools = $Schools;
    }

    public function delete()
    {
        $this->schools->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Schools') ]) ]);
        $this->emit('schoolsDeleted');
    }

    public function render()
    {
        return view('livewire.admin.schools.single')
            ->layout('admin::layouts.app');
    }
}
