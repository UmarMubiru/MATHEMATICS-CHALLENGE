<?php

namespace App\Http\Livewire\Admin\Schools;

use App\Models\Schools;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $district;
    public $registration_number;
    public $email;
    public $representative;

    protected $rules = [
        'name' => 'required|string|max:255',
        'district' => 'required|string|max:255',
        'registration_number' => 'required|string|max:50',
        'email' => 'required|email|max:255',
        'representative' => 'required|string|max:255',
    ];


    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Schools') ])]);

        Schools::create([
            'name' => $this->name,
            'district' => $this->district,
            'registration_number' => $this->registration_number,
            'email' => $this->email,
            'representative' => $this->representative,
            'user_id' => auth()->id(),
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.schools.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Schools') ])]);
    }

}
