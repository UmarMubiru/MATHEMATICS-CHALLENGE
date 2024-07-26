<?php

namespace App\Http\Livewire\Admin\Result;

use App\Models\Result;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $result;

    
    protected $rules = [
        
    ];

    public function mount(Result $Result){
        $this->result = $Result;
        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Result') ]) ]);
        
        $this->result->update([
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.result.update', [
            'result' => $this->result
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Result') ])]);
    }
}
