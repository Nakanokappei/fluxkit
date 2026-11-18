{{-- Preview pattern "Logs": a dashboard with two independent tables on one screen, each paginated under its own page name. --}}
@php
    // Sample data: summary numbers, recent errors with details on a second row, and sign-ins.
    $summary = [['Requests today', '48,211'], ['Errors today', '17'], ['Median response', '182 ms']];
    $errors = [
        ['at' => '10:41:07', 'level' => ['Error', 'red'], 'message' => 'SQLSTATE[40001]: Serialization failure: 1213 Deadlock found', 'where' => 'App\Jobs\SyncInvoices:88', 'trace' => '#0 vendor/laravel/framework/src/Illuminate/Database/Connection.php(825)'],
        ['at' => '10:12:55', 'level' => ['Warning', 'amber'], 'message' => 'Slow request: GET /reports/monthly took 4,812 ms', 'where' => 'App\Http\Controllers\ReportController:41', 'trace' => null],
        ['at' => '09:58:30', 'level' => ['Error', 'red'], 'message' => 'cURL error 28: Operation timed out after 10001 milliseconds', 'where' => 'App\Services\MailGateway:132', 'trace' => '#0 vendor/guzzlehttp/guzzle/src/Handler/CurlFactory.php(210)'],
    ];
    $signIns = [
        ['who' => 'mika.tanaka@example.com', 'where' => 'Tokyo, JP · Chrome on macOS', 'at' => '09:12'],
        ['who' => 'daniel.okafor@example.com', 'where' => 'Lagos, NG · Safari on iOS', 'at' => '08:47'],
        ['who' => 'lena.fischer@example.com', 'where' => 'Berlin, DE · Firefox on Linux', 'at' => '08:03'],
    ];
    $errorsPage = new \Illuminate\Pagination\LengthAwarePaginator($errors, 17, 10, 1, ['pageName' => 'errorsPage']);
    $signInsPage = new \Illuminate\Pagination\LengthAwarePaginator($signIns, 64, 3, 4, ['pageName' => 'signInsPage']);
@endphp

<div class="flex flex-col gap-4">
    {{-- Summary numbers in plain cards. --}}
    <div class="grid gap-4 sm:grid-cols-3">
        @foreach ($summary as [$label, $value])
            <x-fluxkit::card class="flex flex-col gap-1 p-4">
                <flux:text class="text-xs">{{ $label }}</flux:text>
                <span class="text-2xl font-semibold tabular-nums">{{ $value }}</span>
            </x-fluxkit::card>
        @endforeach
    </div>

    {{-- Errors: sortable by time, details on a second row, its own pager (errorsPage). --}}
    <div class="flex flex-col gap-2">
        <div class="flex flex-wrap items-center gap-2">
            <flux:heading size="md">Errors</flux:heading>
            <flux:spacer />
            <x-fluxkit::search-input model="errorSearch" label="Search errors" placeholder="Search message or class" size="sm" class="w-64" />
        </div>
        <x-fluxkit::card class="overflow-x-auto">
            <table class="w-full text-sm">
                <x-fluxkit::table-head>
                    <tr>
                        <x-fluxkit::sortable-th column="at" sort="at" direction="desc" class="w-px whitespace-nowrap">Time</x-fluxkit::sortable-th>
                        <th class="w-px px-3 py-2 font-medium">Level</th>
                        <th class="px-3 py-2 font-medium">Message</th>
                    </tr>
                </x-fluxkit::table-head>
                <tbody>
                    @foreach ($errors as $error)
                        <tr class="border-t border-neutral-100 align-top">
                            <td class="px-3 py-2 tabular-nums text-zinc-500">{{ $error['at'] }}</td>
                            <td class="px-3 py-2"><flux:badge size="sm" :color="$error['level'][1]">{{ $error['level'][0] }}</flux:badge></td>
                            <td class="px-3 py-2">
                                {{ $error['message'] }}
                                <x-fluxkit::cell-sub class="font-mono wrap-anywhere">{{ $error['where'] }}</x-fluxkit::cell-sub>
                            </td>
                        </tr>
                        @if ($error['trace'])
                            <x-fluxkit::sub-row :cols="3">
                                <div class="rounded bg-zinc-50 px-2 py-1 font-mono text-xs text-zinc-500 wrap-anywhere">{{ $error['trace'] }}</div>
                            </x-fluxkit::sub-row>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <x-fluxkit::table-pager :paginator="$errorsPage" per-page="errorsPerPage" />
        </x-fluxkit::card>
    </div>

    <div class="grid items-start gap-4 lg:grid-cols-2">
        {{-- Sign-ins: page navigation alone in the heading row (signInsPage), no rows-per-page select. --}}
        <div class="flex flex-col gap-2">
            <div class="flex items-center justify-between gap-2">
                <flux:heading size="md">Sign-ins</flux:heading>
                <x-fluxkit::page-nav :paginator="$signInsPage" />
            </div>
            <x-fluxkit::card class="overflow-x-auto">
                <table class="w-full text-sm">
                    <tbody>
                        @foreach ($signIns as $signIn)
                            <tr class="border-t border-neutral-100 align-top first:border-t-0">
                                <td class="px-3 py-2">
                                    <span class="wrap-anywhere">{{ $signIn['who'] }}</span>
                                    <x-fluxkit::cell-sub>{{ $signIn['where'] }}</x-fluxkit::cell-sub>
                                </td>
                                <td class="w-px px-3 py-2 tabular-nums text-zinc-500">{{ $signIn['at'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-fluxkit::card>
        </div>

        {{-- Failed jobs: a filtered table that came back empty. --}}
        <div class="flex flex-col gap-2">
            <flux:heading size="md">Failed jobs (last 24 hours)</flux:heading>
            <x-fluxkit::card class="overflow-x-auto">
                <table class="w-full text-sm">
                    <x-fluxkit::table-head>
                        <tr>
                            <th class="px-3 py-2 font-medium">Job</th>
                            <th class="px-3 py-2 font-medium">Failed at</th>
                        </tr>
                    </x-fluxkit::table-head>
                    <tbody>
                        <x-fluxkit::empty-row :cols="2">No failed jobs in this period.</x-fluxkit::empty-row>
                    </tbody>
                </table>
            </x-fluxkit::card>
        </div>
    </div>
</div>
