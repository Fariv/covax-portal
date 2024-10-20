<?php

namespace App\Livewire;

use App\Models\User;
use App\Services\VaccineCenter\VaccineCenterService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Register extends Component
{
    public $name;
    public $nid;
    public $email;
    public $password;
    public $center;
    public $centers;
    public $timezone;

    // Validation rules
    protected $rules = array(
        "name" => "required|string|max:255",
        "email" => "required|string|email|unique:App\Models\User,email|max:255",
        "nid" => "required|string|unique:App\Models\User,nid",
        "password" => "required|string|min:8",
        'center' => 'required|exists:vaccine_centers,id',
        'timezone' => 'required|string',
    );

    protected $vaccineCenterService;

    // Use mount() instead of constructor for dependency injection
    public function mount(VaccineCenterService $vaccineCenterService)
    {
        $this->vaccineCenterService = $vaccineCenterService;
        Log::info('VaccineCenterService initialized', [$this->vaccineCenterService]);
        // Load centers using the injected service
        $this->centers = $this->vaccineCenterService->getAllCenters();
    }
    
    public function register(VaccineCenterService $vaccineCenterService)
    {
        Log::info('Register method called');
        
        $this->vaccineCenterService = $vaccineCenterService;
        
        // Validate the input
        $this->validate($this->rules);

        // Create the new user
        $user = User::create([
            'name' => $this->name,
            'nid' => $this->nid,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        if ($this->vaccineCenterService) {
            Log::info('VaccineCenterService is available');
            // Register the user to the selected vaccine center (if you need to)
            $this->vaccineCenterService->registerUserToCenter($user, $this->center, $this->timezone);
        } else {
            Log::error('VaccineCenterService is null in register method');
        }

        // Redirect or perform another action
        session()->flash('message', 'User registered successfully.');
         // Optionally reset fields or emit events
        $this->reset(["name", "nid", "email", "password", "center",]);

        // return redirect()->route('livewire.register');
    }
    
    public function render()
    {
        // Fetch vaccine centers from the service (if needed)
        $centers = $this->centers;

        return view('livewire.register', [
            'centers' => $centers,
        ]);
    }
}
