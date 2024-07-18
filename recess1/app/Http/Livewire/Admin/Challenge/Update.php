<?php

namespace App\Http\Livewire\Admin\Challenge;

use App\Models\Challenge;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $challenge;

    public $name;
    public $open_date;
    public $close_date;
    public $duration;
    public $no_of_questions;
    
    protected $rules = [
        
    ];

    public function mount(Challenge $Challenge){
        $this->challenge = $Challenge;
        $this->name = $this->challenge->name;
        $this->open_date = $this->challenge->open_date;
        $this->close_date = $this->challenge->close_date;
        $this->duration = $this->challenge->duration;
        $this->no_of_questions = $this->challenge->no_of_questions;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Challenge') ]) ]);
        
        $this->challenge->update([
            'name' => $this->name,
            'open_date' => $this->open_date,
            'close_date' => $this->close_date,
            'duration' => $this->duration,
            'no_of_questions' => $this->no_of_questions,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.challenge.update', [
            'challenge' => $this->challenge
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Challenge') ])]);
    }
}
