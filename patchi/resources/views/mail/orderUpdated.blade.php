<x-mail::message>
    Hello, an Order has been Updated
    <x-mail::button :url="$url">
        View Order
    </x-mail::button>
    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
