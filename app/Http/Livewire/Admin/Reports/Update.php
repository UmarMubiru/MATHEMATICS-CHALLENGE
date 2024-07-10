<?php

namespace App\Http\Livewire\Admin\Reports;

use App\Models\Reports;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $reports;

    
    protected $rules = [
        
    ];

    public function mount(Reports $Reports){
        $this->reports = $Reports;
        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Reports') ]) ]);
        
        $this->reports->update([
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.reports.update', [
            'reports' => $this->reports
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Reports') ])]);
    }
}
