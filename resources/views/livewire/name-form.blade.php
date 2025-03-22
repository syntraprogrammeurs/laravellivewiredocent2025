<div class="p-6 bg-white shadow-md rounded-lg max-w-md mx-auto">
    <h2 class="text-xl font-semibold mb-4 text-center">Registratieformulier</h2>

    {{-- Succesbericht --}}
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Voornaam --}}
    <x-ui.forms.group label="Voornaam" for="firstName">
        <x-ui.forms.input id="firstName" model="firstName" />
    </x-ui.forms.group>

    {{-- Achternaam --}}
    <x-ui.forms.group label="Achternaam" for="lastName">
        <x-ui.forms.input id="lastName" model="lastName" />
    </x-ui.forms.group>

    {{-- E-mail --}}
    <x-ui.forms.group label="E-mailadres" for="email">
        <x-ui.forms.input id="email" type="email" model="email" />
    </x-ui.forms.group>

    {{-- Geslacht (radio) --}}
    <x-ui.forms.group label="Geslacht" for="gender">
        <div class="space-x-4">
            <x-ui.forms.radio name="gender" value="man" model="gender" label="Man" />
            <x-ui.forms.radio name="gender" value="vrouw" model="gender" label="Vrouw" />
            <x-ui.forms.radio name="gender" value="ander" model="gender" label="Ander" />
        </div>
    </x-ui.forms.group>

    {{-- Rolkeuze (select) --}}
    <x-ui.forms.group label="Rol" for="role">
        <x-ui.forms.select id="role" model="role">
            <option value="">Kies je rol</option>
            <option value="student">Student</option>
            <option value="developer">Developer</option>
            <option value="docent">Docent</option>
        </x-ui.forms.select>
    </x-ui.forms.group>

    {{-- Opmerkingen (textarea) --}}
    <x-ui.forms.group label="Opmerkingen" for="comments">
        <x-ui.forms.textarea id="comments" model="comments" placeholder="Schrijf hier je opmerkingen..."></x-ui.forms.textarea>
    </x-ui.forms.group>

    {{-- Checkbox akkoord --}}
    <x-ui.forms.group label=" ">
        <x-ui.forms.checkbox
            id="terms"
            model="accepted"
            label="Ik ga akkoord met de voorwaarden" />
    </x-ui.forms.group>

    {{-- Verstuurknop --}}
    <div class="text-right mt-6">
        <x-ui.button wire:click="submit">
            Verzenden
        </x-ui.button>
    </div>
</div>

