<?php

namespace App\Http\Livewire\Admin\Questions;

use App\Models\Questions;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $questions;

    protected $rules = [
        'questions' => 'required|file|max:1255', // Adjust as needed
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Questions') ])]);

        if($this->getPropertyValue('questions') and is_object($this->questions)) {
            $this->questions = $this->getPropertyValue('questions')->store('questions');
        }

        Questions::create([
            'questions' => $this->questions,
            'user_id' => auth()->id(),
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.questions.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Questions') ])]);
    }
}
