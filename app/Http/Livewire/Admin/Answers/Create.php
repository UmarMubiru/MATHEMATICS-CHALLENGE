<?php

namespace App\Http\Livewire\Admin\Answers;

use App\Models\Answers;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $answers;


    protected $rules = [
        'answers' => 'required|file|max:1255', // Adjust as needed
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Answers') ])]);

        if($this->getPropertyValue('answers') and is_object($this->answers)) {
            $this->answers = $this->getPropertyValue('answers')->store('answers');
        }

        Answers::create([
            'answers' => $this->answers,
            'user_id' => auth()->id(),
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.answers.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Answers') ])]);
    }
}
