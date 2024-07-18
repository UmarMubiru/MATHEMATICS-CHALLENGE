<?php

namespace App\Http\Livewire\Admin\Questions;

use App\Models\Questions;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $questions;

    protected $rules = [

    ];

    public function mount(Questions $Questions){
        $this->questions = $Questions;
        $this->questions = $this->questions->questions;
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Questions') ]) ]);

        if($this->getPropertyValue('questions') and is_object($this->questions)) {
            $this->questions = $this->getPropertyValue('questions')->store('questions');
        }

        $this->questions->update([
            'questions' => $this->questions,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.questions.update', [
            'questions' => $this->questions
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Questions') ])]);
    }
}
