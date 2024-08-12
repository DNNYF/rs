<?php

namespace App\Livewire;

use Livewire\Component;

class Wizard extends Component
{
    public $currentStep = 1;
    public $nama_pasien, $dokter;
    public $successMessage = '';

    public function render()
    {
        return view('livewire.wizard');
    }

    public function firstStepSubmit(){
        $ValidatedData = $this->validate([
            'nama_pasien' => 'required',
            'dokter' => 'required',
        ]);

        $this->currentStep = 2;
    }

    public function secondStepSubmit(){
        $ValidatedData = $this->validate([
            
        ]);
    }

}
