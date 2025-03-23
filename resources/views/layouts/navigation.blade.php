                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                        {{ __('Users') }}
                    </x-nav-link>

                    <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                        {{ __('Roles') }}
                    </x-nav-link> 