@push('head')
    <link
        href="/favicon.ico"
        id="favicon"
        rel="icon"
    >
@endpush

<div class="h2 d-flex align-items-center">
    @auth
        <x-orchid-icon path="bs.house" class="d-inline d-xl-none"/>
    @endauth

    <p  class="mx-auto  {{ auth()->check() ? 'd-none d-xl-block' : '' }}">
        <x-application-logo></x-application-logo>
    </p>
</div>
