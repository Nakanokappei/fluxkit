{{-- Preview pattern "Inbox": a master–detail screen. Rows open in the pane on the right (mouse on the row, or Tab + Enter on the name). --}}
@php
    // Sample data: conversations in the list and the one opened in the pane.
    $conversations = [
        ['id' => 101, 'subject' => 'Cannot export the monthly report as CSV', 'from' => 'Northwind Trading', 'contact' => 'olivia@northwind.example', 'status' => ['Open', 'blue'], 'at' => '10:42'],
        ['id' => 102, 'subject' => 'Invoice address needs to change from next month onwards, including the past two invoices', 'from' => 'Blue Harbor Logistics International', 'contact' => 'kenji@blueharbor.example', 'status' => ['Waiting', 'amber'], 'at' => '09:15'],
        ['id' => 103, 'subject' => 'Two-factor codes arrive late', 'from' => 'Fernwood Clinic', 'contact' => 'it@fernwood.example', 'status' => ['Open', 'blue'], 'at' => 'Yesterday'],
        ['id' => 104, 'subject' => 'Thanks for the quick fix!', 'from' => 'Atlas Studio', 'contact' => 'marta@atlas.example', 'status' => ['Closed', 'zinc'], 'at' => 'Nov 15'],
    ];
    $openId = 101;
    $conversationsPage = new \Illuminate\Pagination\LengthAwarePaginator($conversations, 128, 25, 1, ['pageName' => 'inboxPage']);
@endphp

<div class="grid items-start gap-4 lg:grid-cols-5">
    {{-- The list: search, then a table whose rows open the conversation on the right. --}}
    <x-fluxkit::card class="flex flex-col lg:col-span-2">
        <div class="flex items-center gap-2 border-b border-neutral-100 p-3">
            <x-fluxkit::search-input model="search" label="Search conversations" placeholder="Search subject or sender" size="sm" />
        </div>
        <table class="w-full text-sm">
            <tbody>
                @foreach ($conversations as $conversation)
                    <tr wire:click="open({{ $conversation['id'] }})" @class([
                        'cursor-pointer border-t border-neutral-100 align-top first:border-t-0 hover:bg-zinc-50',
                        'bg-blue-50/60' => $conversation['id'] === $openId,
                    ])>
                        <td class="px-3 py-2">
                            <x-fluxkit::row-select-button action="open({{ $conversation['id'] }})" :selected="$conversation['id'] === $openId" class="font-medium">
                                {{ $conversation['subject'] }}
                            </x-fluxkit::row-select-button>
                            <x-fluxkit::cell-sub class="flex items-center gap-1">
                                <x-fluxkit::name-badge :name="$conversation['from']" color="zinc" max="max-w-40" />
                                <span>· {{ $conversation['at'] }}</span>
                            </x-fluxkit::cell-sub>
                        </td>
                        <td class="w-px px-3 py-2 text-end">
                            <flux:badge size="sm" :color="$conversation['status'][1]">{{ $conversation['status'][0] }}</flux:badge>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-fluxkit::table-pager :paginator="$conversationsPage" per-page="perPage" />
    </x-fluxkit::card>

    {{-- The opened conversation. --}}
    <x-fluxkit::pane name="conversation" class="flex flex-col bg-white lg:col-span-3">
        <x-slot:header>
            <flux:text class="truncate text-xs font-medium text-zinc-500">#101 · Cannot export the monthly report as CSV</flux:text>
            <div class="flex shrink-0 items-center gap-1">
                <flux:button size="xs" variant="ghost" icon="check">Close</flux:button>
                <x-fluxkit::delete-button action="delete(101)" confirm="Delete this conversation?" />
            </div>
        </x-slot:header>

        <div class="flex flex-col gap-3 p-4 text-sm">
            <div class="flex flex-wrap items-center gap-2">
                <x-fluxkit::name-badge name="Northwind Trading" color="zinc" />
                <x-fluxkit::name-badge name="Reporting" color="sky" />
                <span class="text-xs text-zinc-500">olivia@northwind.example</span>
            </div>
            <div class="rounded-lg bg-zinc-50 p-3">
                Hello, when I click "Export CSV" on the monthly report nothing is downloaded. It worked last week.
                <x-fluxkit::cell-sub>Olivia · Today, 10:42</x-fluxkit::cell-sub>
            </div>
            <div class="ms-8 rounded-lg bg-blue-50 p-3">
                Thanks, Olivia — we can reproduce it and are looking into it now.
                <x-fluxkit::cell-sub>You · Today, 10:50</x-fluxkit::cell-sub>
            </div>
        </div>

        {{-- Reply form; the field is required. --}}
        <form method="POST" wire:submit="reply" class="flex flex-col gap-2 border-t border-neutral-100 p-3">
            <flux:textarea label="Reply" badge="Required" rows="3" placeholder="Write a reply…" />
            <div class="flex justify-end">
                <flux:button type="submit" size="sm" variant="primary">Send</flux:button>
            </div>
        </form>
    </x-fluxkit::pane>
</div>
