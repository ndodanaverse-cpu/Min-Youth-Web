<?php

namespace App\Livewire\Dashboard;

use App\Enums\Gender;
use App\Models\District;
use App\Models\Profile as UserProfile;
use App\Models\Province;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Profile extends Component
{
    public ?string $name = '';

    public ?string $phone = '';

    public ?string $national_id = '';

    public ?string $date_of_birth = '';

    public ?string $gender = '';

    public ?string $province_id = '';

    public ?string $district_id = '';

    public ?string $education_level = '';

    public ?string $employment_status = '';

    public ?string $occupation = '';

    public ?string $about = '';

    public bool $saved = false;

    public function mount(): void
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->phone = $user->phone;

        if ($profile = $user->profile) {
            $this->national_id = $profile->national_id;
            $this->date_of_birth = $profile->date_of_birth?->format('Y-m-d');
            $this->gender = $profile->gender?->value;
            $this->province_id = (string) ($profile->province_id ?? '');
            $this->district_id = (string) ($profile->district_id ?? '');
            $this->education_level = $profile->education_level;
            $this->employment_status = $profile->employment_status;
            $this->occupation = $profile->occupation;
            $this->about = $profile->about;
        }
    }

    public function updatedProvinceId(): void
    {
        $this->district_id = '';
        $this->resetValidation('district_id');
    }

    public function save(): void
    {
        $this->validate();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:190'],
            'phone' => ['nullable', 'string', 'max:30'],
            'national_id' => ['nullable', 'string', 'regex:/^\d{2}-\d{6,7}[A-Z]\d{2}$/i', 'max:20'],
            'date_of_birth' => ['required', 'date', 'before:today', 'after_or_equal:1960-01-01'],
            'gender' => ['required', 'in:' . implode(',', array_column(Gender::cases(), 'value'))],
            'province_id' => ['required', 'exists:provinces,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'education_level' => ['nullable', 'string', 'max:40'],
            'employment_status' => ['nullable', 'string', 'max:40'],
            'occupation' => ['nullable', 'string', 'max:190'],
            'about' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
        ]);

        $profile = $user->profile ?? new UserProfile(['user_id' => $user->id]);

        $profile->fill([
            'national_id' => $validated['national_id'] ?: null,
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => Gender::from($validated['gender']),
            'province_id' => $validated['province_id'],
            'district_id' => $validated['district_id'],
            'education_level' => $validated['education_level'] ?: null,
            'employment_status' => $validated['employment_status'] ?: null,
            'occupation' => $validated['occupation'] ?: null,
            'about' => $validated['about'] ?: null,
        ]);

        $profile->save();

        $this->saved = true;
        session()->flash('status', 'Your profile has been updated.');
    }

    public function render()
    {
        return view('livewire.dashboard.profile', [
            'provinces' => Province::orderBy('name')->get(),
            'districts' => $this->province_id
                ? District::where('province_id', $this->province_id)->orderBy('name')->get()
                : collect(),
            'genders' => Gender::cases(),
            'employmentStatuses' => ['employed', 'self-employed', 'student', 'unemployed', 'other'],
            'educationLevels' => ['primary', 'secondary', 'tertiary', 'vocational', 'postgraduate', 'other'],
        ])->layout('layouts.dashboard', ['title' => 'My profile']);
    }
}
