<?php

namespace App\Http\Livewire\Admin\Schools;

use App\Models\Schools;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $schools;

    public $name;
    public $district;
    public $registration_number;
    public $email;
    public $representative;
    
    protected $rules = [
        
    ];

    public function mount(Schools $Schools){
        $this->schools = $Schools;
        $this->name = $this->schools->name;
        $this->district = $this->schools->district;
        $this->registration_number = $this->schools->registration_number;
        $this->email = $this->schools->email;
        $this->representative = $this->schools->representative;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Schools') ]) ]);
        
        $this->schools->update([
            'name' => $this->name,
            'district' => $this->district,
            'registration_number' => $this->registration_number,
            'email' => $this->email,
            'representative' => $this->representative,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.schools.update', [
            'schools' => $this->schools
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Schools') ])]);
    }
}
