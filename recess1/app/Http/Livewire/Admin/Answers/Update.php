<?php

namespace App\Http\Livewire\Admin\Answers;

use App\Models\Answers;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $answers;

    protected $rules = [
        'answers' => 'required|file|max:1255', // Adjust as needed
    ];

    public function mount(Answers $Answers){
        $this->answers = $Answers;
    }


    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Answers') ]) ]);

        if($this->getPropertyValue('answers') and is_object($this->answers)) {
            $this->answers = $this->getPropertyValue('answers')->store('answers');
        }

        $this->answers->update([
            'answers' => $this->answers,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.answers.update', [
            'answers' => $this->answers
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Answers') ])]);
    }
}
