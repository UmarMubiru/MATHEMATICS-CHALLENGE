<?php

namespace App\Http\Livewire\Admin\Result;

use App\Models\Result;
use Livewire\Component;

class Single extends Component
{

    public $result;

    public function mount(Result $Result){
        $this->result = $Result;
    }

    public function delete()
    {
        $this->result->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Result') ]) ]);
        $this->emit('resultDeleted');
    }

    public function render()
    {
        return view('livewire.admin.result.single')
            ->layout('admin::layouts.app');
    }
}
