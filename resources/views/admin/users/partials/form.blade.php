<x-ui.card>
    <form method="POST" action="{{ $action }}" class="grid gap-5 md:grid-cols-2">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif
        <x-ui.input name="name" label="Name" :value="$user->name" />
        <x-ui.input name="email" label="Email" :value="$user->email" />
        <x-ui.input name="phone" label="Phone" :value="$user->phone" />
        <x-ui.input name="headline" label="Headline" :value="$user->headline" />
        <x-ui.select name="role" label="Role">
            @foreach (['admin', 'vendor', 'customer'] as $role)
                <option value="{{ $role }}" @selected(old('role', $user->roles->first()?->name) === $role)>{{ ucfirst($role) }}</option>
            @endforeach
        </x-ui.select>
        <div></div>
        <x-ui.input name="password" label="Password" type="password" />
        <x-ui.input name="password_confirmation" label="Confirm password" type="password" />
        <div class="md:col-span-2">
            <x-ui.button type="submit">Save user</x-ui.button>
        </div>
    </form>
</x-ui.card>
