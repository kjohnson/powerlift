<?php

namespace App\Livewire;

use App\Models\FitnessClass;
use App\Models\FitnessClassSession;
use Illuminate\Support\Collection;
use Livewire\Component;

class Sessions extends Component
{
    public FitnessClass $fitnessClass;

    public FitnessClassSession|null $selectedSession;

    public function mount(FitnessClass $fitnessClass)
    {
        $this->fitnessClass = $fitnessClass;
    }

    public function render()
    {
        return view('livewire.sessions')
            ->title('Class Sessions');
    }

    public function selectSession($id)
    {
        $this->selectedSession = FitnessClassSession::findOrFail($id);
    }

    public function resetSelectedSession()
    {
        unset($this->selectedSession);
    }
}
