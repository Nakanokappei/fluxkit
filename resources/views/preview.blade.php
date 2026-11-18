{{--
    Preview of the fluxkit components (GET /fluxkit-preview; config fluxkit.preview; development only).

    A sample "user management" screen built only from Flux and fluxkit, so the components can be seen the way an app
    uses them. All 20 components appear somewhere on this screen. It is not inside a Livewire component, so buttons
    such as wire:click do nothing. When adding a component, add it here too (a SKILL.md rule).
    The sample text is read only by developers, so it is not translated.
--}}
@php
    // Sample data: a list of users, the one opened on the right, and paginators for the table and the activity log.
    $users = [
        ['id' => 1, 'name' => 'Mika Tanaka', 'email' => 'mika.tanaka@example.com', 'role' => 'Admin', 'teams' => [['Platform', 'blue'], ['Design review', 'violet']], 'last' => 'Today, 09:12'],
        ['id' => 2, 'name' => 'Daniel Okafor', 'email' => 'daniel.okafor@example.com', 'role' => 'Member', 'teams' => [['Customer success, Asia-Pacific region', 'green']], 'last' => 'Yesterday'],
        ['id' => 3, 'name' => 'Lena Fischer', 'email' => 'lena.fischer@example.com', 'role' => 'Member', 'teams' => [['Platform', 'blue']], 'last' => 'Nov 12'],
        ['id' => 4, 'name' => 'Sora Ito', 'email' => 'sora.ito@example.com', 'role' => 'Viewer', 'teams' => [], 'last' => null],
        ['id' => 5, 'name' => 'Priya Nair', 'email' => 'priya.nair@example.com', 'role' => 'Member', 'teams' => [['Billing', 'amber'], ['Platform', 'blue'], ['On-call', 'red']], 'last' => 'Oct 30'],
    ];
    $selectedId = 1;
    $usersPage = new \Illuminate\Pagination\LengthAwarePaginator($users, 42, 5, 1, ['pageName' => 'usersPage']);
    $activityPage = new \Illuminate\Pagination\LengthAwarePaginator([], 37, 3, 2, ['pageName' => 'activityPage']);
    $noUsers = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10, 1, ['pageName' => 'suspendedPage']);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>fluxkit preview</title>
    @vite(config('fluxkit.preview.vite'))
    @fluxAppearance(['nonce' => Vite::cspNonce()])
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-800">
<x-fluxkit::busy />

<main class="mx-auto flex max-w-6xl flex-col gap-6 p-8" data-test="fluxkit-preview">
    {{-- What this page is. --}}
    <div class="flex flex-col gap-1 rounded-lg bg-zinc-800 px-4 py-3 text-sm text-zinc-100">
        <span class="font-medium">fluxkit preview — a sample user management screen</span>
        <span class="text-zinc-300">Built only from Flux and the 20 fluxkit components. Static: buttons do nothing. Usage and props are in the package's SKILL.md.</span>
    </div>

    <x-fluxkit::admin-page icon="cog-6-tooth" title="Administration" heading="Users"
        subheading="Manage who can sign in, their roles and the teams they belong to.">

        {{-- Toolbar: type-to-filter search, a role filter and the invite button. --}}
        <div class="flex flex-wrap items-center gap-2">
            <x-fluxkit::search-input model="search" label="Search users" placeholder="Search by name or email" class="w-72" />
            <flux:select size="sm" class="w-36" aria-label="Role">
                <flux:select.option>All roles</flux:select.option>
                <flux:select.option>Admin</flux:select.option>
                <flux:select.option>Member</flux:select.option>
                <flux:select.option>Viewer</flux:select.option>
            </flux:select>
            <flux:spacer />
            <flux:button size="sm" variant="primary" icon="plus">Invite user</flux:button>
        </div>

        {{-- Invite form in a dashed box, with plain labels marked required. --}}
        <x-fluxkit::dashed-box as="form" method="POST" wire:submit="invite" class="flex flex-wrap items-end gap-3">
            <div class="flex flex-col gap-1">
                <label for="invite-email" class="text-sm font-medium">Email <x-fluxkit::required-badge /></label>
                <input id="invite-email" type="email" aria-required="true" placeholder="name@example.com"
                    class="h-8 w-64 rounded-md border border-zinc-200 bg-white px-2 text-sm" />
            </div>
            <div class="flex flex-col gap-1">
                <label for="invite-role" class="text-sm font-medium">Role <x-fluxkit::required-badge /></label>
                <select id="invite-role" aria-required="true" class="h-8 w-36 rounded-md border border-zinc-200 bg-white px-2 text-sm">
                    <option>Member</option>
                    <option>Admin</option>
                    <option>Viewer</option>
                </select>
            </div>
            <flux:button type="submit" size="sm">Send invitation</flux:button>
        </x-fluxkit::dashed-box>

        <div class="grid items-start gap-4 lg:grid-cols-3">
            {{-- The user table: sortable headers, a keyboard entry per row, name badges, a second row and the pager. --}}
            <x-fluxkit::card class="overflow-x-auto lg:col-span-2">
                <table class="w-full text-sm">
                    <x-fluxkit::table-head>
                        <tr>
                            <x-fluxkit::sortable-th column="name" sort="name" direction="asc">Name</x-fluxkit::sortable-th>
                            <th class="px-3 py-2 font-medium">Teams</th>
                            <x-fluxkit::sortable-th column="last_sign_in" sort="name" direction="asc" class="w-px whitespace-nowrap">Last sign-in</x-fluxkit::sortable-th>
                        </tr>
                    </x-fluxkit::table-head>
                    <tbody>
                        @foreach ($users as $user)
                            <tr @class([
                                'cursor-pointer border-t border-neutral-100 align-top hover:bg-zinc-50',
                                'bg-blue-50/60' => $user['id'] === $selectedId,
                            ]) wire:click="select({{ $user['id'] }})">
                                <td class="px-3 py-2">
                                    <x-fluxkit::row-select-button action="select({{ $user['id'] }})" :selected="$user['id'] === $selectedId" class="font-medium">
                                        {{ $user['name'] }}
                                    </x-fluxkit::row-select-button>
                                    <x-fluxkit::cell-sub class="wrap-anywhere">{{ $user['email'] }} · {{ $user['role'] }}</x-fluxkit::cell-sub>
                                </td>
                                <td class="px-3 py-2">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse ($user['teams'] as [$team, $color])
                                            <x-fluxkit::name-badge :name="$team" :color="$color" />
                                        @empty
                                            <span class="text-zinc-400">—</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-zinc-500">{{ $user['last'] ?? 'Never' }}</td>
                            </tr>
                            @if ($user['last'] === null)
                                {{-- A pending invitation gets its actions on a second row. --}}
                                <x-fluxkit::sub-row :cols="3" align="end">
                                    <div class="flex items-center justify-end gap-2">
                                        <span class="text-xs text-amber-700">Invitation pending</span>
                                        <flux:button size="xs" variant="ghost" icon="arrow-path">Resend</flux:button>
                                        <x-fluxkit::delete-button action="cancelInvitation({{ $user['id'] }})" label="Cancel invitation" confirm="Cancel this invitation?" />
                                    </div>
                                </x-fluxkit::sub-row>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <x-fluxkit::table-pager :paginator="$usersPage" per-page="perPage" :options="[5, 10, 25]" />
            </x-fluxkit::card>

            {{-- Details of the selected user in a pane. --}}
            <x-fluxkit::pane name="user-details" class="flex flex-col bg-white">
                <x-slot:header>
                    <flux:text class="text-xs font-medium text-zinc-500">Mika Tanaka</flux:text>
                    <x-fluxkit::delete-button action="deleteUser(1)" size="xs" :danger="true" label="Delete account"
                        confirm="Delete this account? This cannot be undone." />
                </x-slot:header>

                <div class="flex flex-col gap-4 p-3 text-sm">
                    <dl class="grid grid-cols-3 gap-x-2 gap-y-1">
                        <dt class="text-zinc-500">Email</dt>
                        <dd class="col-span-2 wrap-anywhere">mika.tanaka@example.com</dd>
                        <dt class="text-zinc-500">Role</dt>
                        <dd class="col-span-2">Admin</dd>
                    </dl>

                    {{-- Team order, reordered by dragging. --}}
                    <div class="flex flex-col gap-1">
                        <flux:heading size="sm">Teams (drag to set the primary team)</flux:heading>
                        <ul wire:sort="reorderTeams" class="flex flex-col gap-1">
                            @foreach ([['Platform', 'blue'], ['Design review', 'violet']] as [$team, $color])
                                <li wire:sort:item="{{ $team }}" class="flex items-center gap-2">
                                    <x-fluxkit::sort-handle :name="$team" :wide="false" />
                                    <x-fluxkit::name-badge :name="$team" :color="$color" />
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Recent activity with page navigation alone. --}}
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center justify-between gap-2">
                            <flux:heading size="sm" class="whitespace-nowrap">Recent activity</flux:heading>
                            <x-fluxkit::page-nav :paginator="$activityPage" />
                        </div>
                        <ul class="flex flex-col divide-y divide-neutral-100">
                            <li class="py-1.5">Signed in<x-fluxkit::cell-sub>Today, 09:12</x-fluxkit::cell-sub></li>
                            <li class="py-1.5">Changed role of Sora Ito to Viewer<x-fluxkit::cell-sub>Yesterday, 17:40</x-fluxkit::cell-sub></li>
                            <li class="py-1.5">Invited sora.ito@example.com<x-fluxkit::cell-sub>Yesterday, 17:38</x-fluxkit::cell-sub></li>
                        </ul>
                    </div>

                    {{-- An empty list inside the pane. --}}
                    <div class="flex flex-col gap-1">
                        <flux:heading size="sm">API tokens</flux:heading>
                        <x-fluxkit::card>
                            <x-fluxkit::empty-note :bare="true">No API tokens.</x-fluxkit::empty-note>
                        </x-fluxkit::card>
                    </div>
                </div>
            </x-fluxkit::pane>
        </div>

        {{-- Empty states: a table with no rows, a short note and a large dashed box. --}}
        <div class="grid gap-4 lg:grid-cols-3">
            <div class="flex flex-col gap-2 lg:col-span-2">
                <flux:heading size="md">Suspended users</flux:heading>
                <x-fluxkit::card class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <x-fluxkit::table-head>
                            <tr>
                                <th class="px-3 py-2 font-medium">Name</th>
                                <th class="px-3 py-2 font-medium">Suspended on</th>
                            </tr>
                        </x-fluxkit::table-head>
                        <tbody>
                            <x-fluxkit::empty-row :cols="2">No suspended users.</x-fluxkit::empty-row>
                        </tbody>
                    </table>
                    <x-fluxkit::table-pager :paginator="$noUsers" per-page="suspendedPerPage" />
                </x-fluxkit::card>
                <x-fluxkit::empty-note>Single sign-on is not configured.</x-fluxkit::empty-note>
            </div>
            <div class="flex flex-col gap-2">
                <flux:heading size="md">Groups</flux:heading>
                <x-fluxkit::empty-state class="border-neutral-300 bg-white p-8 text-center">
                    <flux:icon icon="user-group" class="size-8 text-zinc-400" />
                    <flux:heading>No groups yet</flux:heading>
                    <flux:text>Groups let you grant access to several users at once.</flux:text>
                    <flux:button size="sm" icon="plus">Create group</flux:button>
                </x-fluxkit::empty-state>
            </div>
        </div>
    </x-fluxkit::admin-page>
</main>

@livewireScripts
@fluxScripts(['nonce' => Vite::cspNonce()])
</body>
</html>
