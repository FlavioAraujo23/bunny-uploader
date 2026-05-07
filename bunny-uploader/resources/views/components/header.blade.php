<flux:header container class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

    <flux:brand href="{{ route('collections.home') }}" name="Bunny Uploader" class="max-lg:hidden dark:hidden" />
    <flux:brand href="{{ route('collections.home') }}" name="Bunny Uploader" class="max-lg:hidden! hidden dark:flex" />

    <flux:spacer />

    <flux:navbar class="-mb-px max-lg:hidden">
        <flux:navbar.item icon="home" href="{{ route('collections.home') }}">Home</flux:navbar.item>
        <flux:navbar.item icon="inbox" href="{{ route('collections.index') }}">Collections</flux:navbar.item>
        <flux:navbar.item icon="document-text" href="{{ route('videos.index') }}">Videos</flux:navbar.item>
        <flux:navbar.item icon="calendar" href="{{ route('export.index') }}">Exports</flux:navbar.item>
    </flux:navbar>

    <flux:spacer />
</flux:header>

<flux:sidebar sticky collapsible="mobile"
    class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.nav>
        <flux:sidebar.item icon="home" href="{{ route('collections.home') }}">Home</flux:sidebar.item>
        <flux:sidebar.item icon="inbox" href="{{ route('collections.index') }}">Collections</flux:sidebar.item>
        <flux:sidebar.item icon="document-text" href="{{ route('videos.index') }}">Videos</flux:sidebar.item>
        <flux:sidebar.item icon="calendar" href="{{ route('export.index') }}">Exports</flux:sidebar.item>
    </flux:sidebar.nav>
</flux:sidebar>
