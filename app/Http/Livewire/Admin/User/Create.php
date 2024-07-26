<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $password;

    protected $rules = [

    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('User') ])]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'user_id' => auth()->id(),
        ]);

    // Add user to the panel
    $this->addUserToPanel($user);

    // Optionally, you can redirect the user or perform other actions
    session()->flash('message', 'Registration successful!');
    return redirect()->route('home');
}

protected function addUserToPanel($user)
{
    // Assuming EasyPanel has a method to add users
    // Replace this with actual API call or method to integrate with EasyPanel
    $easyPanelApi = new EasyPanelApi(); // Hypothetical API client
    $easyPanelApi->addUser([
        'name' => $user->name,
        'email' => $user->email,
        'role' => 'user', // or any specific role
    ]);
}

    public function render()
    {
        return view('livewire.admin.user.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('User') ])]);
    }
}
