{{-- Preview pattern "First run": the same kinds of screens before there is any data — large and small empty states. --}}
@php
    $noProjects = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10, 1, ['pageName' => 'projectsPage']);
@endphp

<x-fluxkit::admin-page icon="folder" title="Workspace" heading="Projects" subheading="Projects group requests, labels and people.">
    {{-- The main area has nothing yet: a large dashed box with the next step. --}}
    <x-fluxkit::empty-state class="border-neutral-300 bg-white p-12 text-center">
        <flux:icon icon="folder-plus" class="size-10 text-zinc-400" />
        <flux:heading size="lg">Create your first project</flux:heading>
        <flux:text class="max-w-md">A project keeps related requests together. You can invite people and add labels once it exists.</flux:text>
        <div class="flex gap-2">
            <flux:button variant="primary" icon="plus">New project</flux:button>
            <flux:button variant="ghost">Import from CSV</flux:button>
        </div>
    </x-fluxkit::empty-state>

    <div class="grid items-start gap-4 lg:grid-cols-3">
        {{-- An empty table keeps its header and pager, with one row saying why it is empty. --}}
        <div class="flex flex-col gap-2 lg:col-span-2">
            <div class="flex flex-wrap items-center gap-2">
                <flux:heading size="md">All projects</flux:heading>
                <flux:spacer />
                <x-fluxkit::search-input model="search" label="Search projects" placeholder="Search projects" size="sm" class="w-56" />
            </div>
            <x-fluxkit::card class="overflow-x-auto">
                <table class="w-full text-sm">
                    <x-fluxkit::table-head>
                        <tr>
                            <x-fluxkit::sortable-th column="name" sort="name" direction="asc">Name</x-fluxkit::sortable-th>
                            <th class="px-3 py-2 font-medium">Owner</th>
                            <x-fluxkit::sortable-th column="updated_at" sort="name" direction="asc" class="w-px whitespace-nowrap">Updated</x-fluxkit::sortable-th>
                        </tr>
                    </x-fluxkit::table-head>
                    <tbody>
                        <x-fluxkit::empty-row :cols="3">No projects yet.</x-fluxkit::empty-row>
                    </tbody>
                </table>
                <x-fluxkit::table-pager :paginator="$noProjects" per-page="perPage" />
            </x-fluxkit::card>
        </div>

        {{-- Side panes with small notes. --}}
        <div class="flex flex-col gap-4">
            <x-fluxkit::pane name="recent" class="bg-white">
                <x-slot:header>
                    <flux:text class="text-xs font-medium text-zinc-500">Recently viewed</flux:text>
                </x-slot:header>
                <x-fluxkit::empty-note :bare="true">Projects you open appear here.</x-fluxkit::empty-note>
            </x-fluxkit::pane>
            <x-fluxkit::empty-note>Nobody has been invited yet.</x-fluxkit::empty-note>
        </div>
    </div>
</x-fluxkit::admin-page>
