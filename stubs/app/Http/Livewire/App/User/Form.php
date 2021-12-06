<?php

namespace App\Http\Livewire\App\User;

use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class Form extends Component
{
    public $user;
    public $form;
    public $roles;
    public $sendVerifyEmail;
    public $sendAccountActivationEmail;

    protected function rules()
    {
        return [
            'form.name' => 'required',
            'form.email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user),
            ],
            'form.password' => 'nullable|min:8',
            'form.role_id' => 'required',
        ];
    }

    /**
     * Mount component
     * 
     * @return void
     */
    public function mount()
    {
        $this->form = [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'password' => null,
            'role_id' => $this->user->role_id,
        ];
        
        $this->isSelf = $this->user->id === auth()->id();
        $this->sendVerifyEmail = false;
        $this->sendAccountActivationEmail = !$this->user->exists;

        $this->roles = Role::assignables()
            ->get()
            ->map(fn($role) => ['value' => $role->id, 'label' => $role->name]);
    }

    /**
     * Rendering livewire view
     * 
     * @return Response
     */
    public function render()
    {
        return view('livewire.app.user.form');
    }

    /**
     * Save user
     * 
     * @return void
     */
    public function save()
    {
        $this->validateinputs();

        $verify = $this->user->exists && $this->user->mustVerifyEmail && $this->form['email'] !== $this->user->email;
        $data = Arr::only($this->form, ['name', 'email', 'role_id']);
        $this->user->fill($data)->save();

        if ($password = $this->form['password'] ? bcrypt($this->form['password']) : null) {
            if ($this->isSelf) {
                $this->user->update(['password' => $password]);
            }
        }

        if ($verify) {
            $this->user->update(['email_verified_at' => null]);
            $this->user->sendEmailVerificationNotification();
        }

        if ($this->sendAccountActivationEmail) {
            $this->user->sendAccountActivation();
        }

        $this->emitUp('saved');
    }

    /**
     * Validate inputs
     * 
     * @return void
     */
    private function validateinputs()
    {
        $this->resetValidation();

        $validator = validator(
            ['form' => $this->form],
            $this->rules(),
            [
                'form.name.required' => 'Name is required.',
                'form.email.required' => 'Login email is required.',
                'form.email.email' => 'Invalid email address.',
                'form.email.unique' => 'Login email is already taken.',
                'form.password.min' => 'Password must be at least 8 characters.',
                'form.role_id.required' => 'Role is required.',
            ]
        );

        if ($validator->fails()) {
            $this->dispatchBrowserEvent('toast', 'formError');
            $validator->validate();
        }
    }
}