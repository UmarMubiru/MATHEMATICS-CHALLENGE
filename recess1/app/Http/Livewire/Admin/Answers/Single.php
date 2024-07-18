<?php

namespace App\Http\Livewire\Admin\Answers;

use App\Models\Answers;
use Livewire\Component;

class Single extends Component
{

    public $answers;

    public function mount(Answers $Answers){
        $this->answers = $Answers;
    }

    public function delete()
    {
        $this->answers->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Answers') ]) ]);
        $this->emit('answersDeleted');
    }

    public function render()
    {
        return view('livewire.admin.answers.single')
            ->layout('admin::layouts.app');
    }
}
