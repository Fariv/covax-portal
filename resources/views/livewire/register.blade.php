<div>
    <div wire:loading style="background: url('{{ url(Storage::url('loader.gif')) }}') center no-repeat;width: 100%;height: 100vh;position: absolute;"></div>
    @if (session()->has('message'))
        <div>
            <div style="background-color: lightgreen; color: darkgreen; padding: 8px; display: inline-block;">
                {{ session('message') }}
            </div>
        </div>
    @endif
    <form wire:submit.prevent="register">
        <!-- Name -->
        <div>
            <label for="name">Name</label>
            <div>
                <input type="text" id="name" wire:model="name" required>
            </div>
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <!-- NID -->
        <div>
            <label for="nid">NID</label>
            <div>
                <input type="text" id="nid" wire:model="nid" required>
            </div>
            @error('nid') <span class="error">{{ $message }}</span> @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email">Email</label>
            <div>
                <input type="email" id="email" wire:model="email" required>
            </div>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password">Password</label>
            <div>
                <input type="password" id="password" wire:model="password" required>
            </div>
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <!-- Center -->
        <div>
            <label for="center">Vaccine Center</label>
            <div>
                <select id="center" wire:model="center" required>
                    <option value="">Select a center</option>
                    @foreach($centers as $center)
                        <option value="{{ $center->id }}">{{ $center->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('center') <span class="error">{{ $message }}</span> @enderror
        </div>

        <!-- Timezone (Hidden) -->
        <input type="hidden" id="timezone" wire:model="timezone">

        <button type="submit">Register</button>
    </form>

    <!-- JavaScript to capture the timezone -->
    @script
    <script>
        document.addEventListener('livewire:initialized', function () {
            const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            document.getElementById('timezone').value = userTimezone;

            // Livewire needs to know about the timezone, so let's notify it
            @this.set('timezone', userTimezone);
        });
    </script>
    @endscript
</div>
