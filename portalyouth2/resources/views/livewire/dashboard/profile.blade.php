<div class="mx-auto max-w-3xl">
    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-gov-200 bg-gov-50 px-5 py-4 text-sm font-semibold text-gov-800" role="status">
            <x-icon name="check-circle" class="size-5 shrink-0 text-gov-600" />
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-8">
        {{-- Account --}}
        <section class="rounded-[1.5rem] border border-charcoal-100 bg-white p-7 shadow-soft">
            <h2 class="font-display text-lg font-bold text-charcoal-900">Account details</h2>

            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-semibold text-charcoal-800">Full name</label>
                    <input id="name" type="text" wire:model="name" autocomplete="name"
                           class="mt-2 w-full rounded-xl border-charcoal-200 text-sm focus:border-gov-500 focus:ring-gov-500">
                    @error('name') <p class="mt-1 text-xs font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-semibold text-charcoal-800">Phone number</label>
                    <input id="phone" type="tel" wire:model="phone" autocomplete="tel" placeholder="+263 ..."
                           class="mt-2 w-full rounded-xl border-charcoal-200 text-sm focus:border-gov-500 focus:ring-gov-500">
                    @error('phone') <p class="mt-1 text-xs font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="email" class="block text-sm font-semibold text-charcoal-800">Email address</label>
                    <input id="email" type="email" value="{{ auth()->user()->email }}" readonly disabled
                           class="mt-2 w-full cursor-not-allowed rounded-xl border-charcoal-100 bg-mist-50 text-sm text-charcoal-500">
                    <p class="mt-1 text-xs text-charcoal-500">Your email is your login and can't be changed here.</p>
                </div>
            </div>
        </section>

        {{-- Identity --}}
        <section class="rounded-[1.5rem] border border-charcoal-100 bg-white p-7 shadow-soft">
            <h2 class="font-display text-lg font-bold text-charcoal-900">Identity</h2>

            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="national_id" class="block text-sm font-semibold text-charcoal-800">National ID (optional)</label>
                    <input id="national_id" type="text" wire:model="national_id" placeholder="63-1234567A00" autocomplete="off"
                           class="mt-2 w-full rounded-xl border-charcoal-200 text-sm focus:border-gov-500 focus:ring-gov-500">
                    @error('national_id') <p class="mt-1 text-xs font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                    <p class="mt-1 text-xs text-charcoal-500">Format: 63-1234567A00</p>
                </div>
                <div>
                    <label for="date_of_birth" class="block text-sm font-semibold text-charcoal-800">Date of birth</label>
                    <input id="date_of_birth" type="date" wire:model="date_of_birth" max="{{ now()->subYears(15)->format('Y-m-d') }}"
                           class="mt-2 w-full rounded-xl border-charcoal-200 text-sm focus:border-gov-500 focus:ring-gov-500">
                    @error('date_of_birth') <p class="mt-1 text-xs font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="gender" class="block text-sm font-semibold text-charcoal-800">Gender</label>
                    <select id="gender" wire:model="gender" class="mt-2 w-full rounded-xl border-charcoal-200 text-sm focus:border-gov-500 focus:ring-gov-500">
                        <option value="">Select gender</option>
                        @foreach ($genders as $g)
                            <option value="{{ $g->value }}">{{ $g->label() }}</option>
                        @endforeach
                    </select>
                    @error('gender') <p class="mt-1 text-xs font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="province_id" class="block text-sm font-semibold text-charcoal-800">Province</label>
                    <select id="province_id" wire:model="province_id" wire:change="updatedProvinceId" class="mt-2 w-full rounded-xl border-charcoal-200 text-sm focus:border-gov-500 focus:ring-gov-500">
                        <option value="">Select province</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                    @error('province_id') <p class="mt-1 text-xs font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="district_id" class="block text-sm font-semibold text-charcoal-800">District</label>
                    <select id="district_id" wire:model="district_id" class="mt-2 w-full rounded-xl border-charcoal-200 text-sm focus:border-gov-500 focus:ring-gov-500" @disabled($districts->isEmpty())>
                        <option value="">Select district</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                    </select>
                    @error('district_id') <p class="mt-1 text-xs font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="education_level" class="block text-sm font-semibold text-charcoal-800">Highest education</label>
                    <select id="education_level" wire:model="education_level" class="mt-2 w-full rounded-xl border-charcoal-200 text-sm focus:border-gov-500 focus:ring-gov-500">
                        <option value="">Select level</option>
                        @foreach ($educationLevels as $level)
                            <option value="{{ $level }}">{{ ucfirst(str_replace('-', ' ', $level)) }}</option>
                        @endforeach
                    </select>
                    @error('education_level') <p class="mt-1 text-xs font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="employment_status" class="block text-sm font-semibold text-charcoal-800">Employment status</label>
                    <select id="employment_status" wire:model="employment_status" class="mt-2 w-full rounded-xl border-charcoal-200 text-sm focus:border-gov-500 focus:ring-gov-500">
                        <option value="">Select status</option>
                        @foreach ($employmentStatuses as $status)
                            <option value="{{ $status }}">{{ ucfirst(str_replace('-', ' ', $status)) }}</option>
                        @endforeach
                    </select>
                    @error('employment_status') <p class="mt-1 text-xs font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="occupation" class="block text-sm font-semibold text-charcoal-800">Occupation / field of work</label>
                    <input id="occupation" type="text" wire:model="occupation" class="mt-2 w-full rounded-xl border-charcoal-200 text-sm focus:border-gov-500 focus:ring-gov-500">
                    @error('occupation') <p class="mt-1 text-xs font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="about" class="block text-sm font-semibold text-charcoal-800">About you</label>
                    <textarea id="about" wire:model="about" rows="4" placeholder="Tell us about your goals, interests and skills..."
                              class="mt-2 w-full rounded-xl border-charcoal-200 text-sm focus:border-gov-500 focus:ring-gov-500"></textarea>
                    @error('about') <p class="mt-1 text-xs font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                </div>
            </div>
        </section>

        <div class="flex justify-end">
            <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center gap-2 rounded-full bg-gold-400 px-8 py-3.5 text-sm font-semibold text-charcoal-900 transition-colors hover:bg-gold-300">
                <span wire:loading wire:target="save">Saving…</span>
                <span wire:loading.remove wire:target="save">Save changes</span>
            </button>
        </div>
    </form>
</div>
