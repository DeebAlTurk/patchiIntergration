<x-mail::message>
Hello, a new Order has been added
<x-mail::button :url="$url">
View Order
</x-mail::button>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
