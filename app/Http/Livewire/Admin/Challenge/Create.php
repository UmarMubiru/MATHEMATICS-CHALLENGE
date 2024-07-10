<?php

namespace App\Http\Livewire\Admin\Challenge;

use App\Models\Challenge;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $open_date;
    public $close_date;
    public $duration;
    public $no_of_questions;

    protected $rules = [
        'name' => 'required|string|max:255',
        'open_date' => 'required|date|max:255',
        'close_date' => 'required|date|max:50',
        'duration' => 'required|numeric|max:255',
        'no_of_questions' => 'required|numeric|max:255',
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Challenge') ])]);

        Challenge::create([
            'name' => $this->name,
            'open_date' => $this->open_date,
            'close_date' => $this->close_date,
            'duration' => $this->duration,
            'no_of_questions' => $this->no_of_questions,
            'user_id' => auth()->id(),
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.challenge.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Challenge') ])]);
    }
}
