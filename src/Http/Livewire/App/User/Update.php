<?php

namespace Jiannius\Atom\Http\Livewire\App\User;

use Livewire\Component;
use App\Models\User;
use Jiannius\Atom\Models\Team;

class Update extends Component
{
    public User $user;

    protected $listeners = ['saved', 'leaveTeam'];

    /**
     * Rendering livewire view
     * 
     * @return Response
     */
    public function render()
    {
        $data = [];

        if (enabled_feature('teams')) $data['teams'] = Team::query()->userId($this->user->id)->get();

        return view('atom::app.user.update', $data);
    }

    /**
     * Saved action
     * 
     * @return void
     */
    public function saved()
    {
        $this->dispatchBrowserEvent('toast', ['message' => 'User Updated', 'type' => 'success']);
    }

    /**
     * Delete user
     * 
     * @return void
     */
    public function delete()
    {
        $this->user->delete();
        session()->flash('flash', 'User deleted');
        return redirect()->route('user.listing');
    }

    /**
     * Get teams to join
     * 
     * @return Team
     */
    public function getTeams($page, $text = null)
    {
        return Team::query()
            ->when($text, fn($q) => $q->search($text))
            ->orderBy('name')
            ->paginate(30, ['*'], 'page', $page)
            ->toArray();
    }

    /**
     * Join team
     * 
     * @return void
     */
    public function joinTeam($id)
    {
        $this->user->joinTeam($id);
        $this->dispatchBrowserEvent('toast', ['message' => 'User joined team', 'type' => 'success']);
    }

    /**
     * Leave team
     * 
     * @return void
     */
    public function leaveTeam($id)
    {
        $this->user->leaveTeam($id);
        $this->dispatchBrowserEvent('toast', ['message' => 'User leaved team']);
    }

    /**
     * Reset abilities
     * 
     * @return void
     */
    public function resetAbilities()
    {
        $this->user->abilities()->detach();
        $this->dispatchBrowserEvent('toast', ['message' => 'Permissions Updated']);
    }
}