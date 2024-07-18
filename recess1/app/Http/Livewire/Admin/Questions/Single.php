<?php

namespace App\Http\Livewire\Admin\Questions;

use App\Models\Questions;
use Livewire\Component;

class Single extends Component
{

    public $questions;

    public function mount(Questions $Questions){
        $this->questions = $Questions;
    }

    public function delete()
    {
        $this->questions->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Questions') ]) ]);
        $this->emit('questionsDeleted');
    }

    public function render()
    {
        return view('livewire.admin.questions.single')
            ->layout('admin::layouts.app');
    }
}
