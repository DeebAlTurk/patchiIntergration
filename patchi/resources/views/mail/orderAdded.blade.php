<x-mail::message>
Hello, a new Order has been added, please add the delivery provider, and the order supervisor
<x-mail::button :url="$url">
View Order
</x-mail::button>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
