<?php

namespace App\Http\Livewire\Admin\Reports;

use App\Models\Reports;
use Livewire\Component;

class Single extends Component
{

    public $reports;

    public function mount(Reports $Reports){
        $this->reports = $Reports;
    }

    public function delete()
    {
        $this->reports->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Reports') ]) ]);
        $this->emit('reportsDeleted');
    }

    public function render()
    {
        return view('livewire.admin.reports.single')
            ->layout('admin::layouts.app');
    }
}
