<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @if(Auth::user()->hasRole('user'))
                {{ __('Orders Dashboard') }}
            @elseif(Auth::user()->hasRole('admin'))
                please go to admin panel <a href="{{route('voyager.login')}}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Click here
                </a>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-3 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-3 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="min-w-full text-left text-sm font-light">
                                        <thead class="border-b font-medium dark:border-neutral-500">
                                        <tr>
                                            <th scope="col" class=" py-4">Policy Number</th>
                                            <th scope="col" class=" py-4">Category</th>
                                            <th scope="col" class=" py-4">Receiver Name</th>
                                            <th scope="col" class=" py-4">Phone Number</th>
                                            <th scope="col" class=" py-4">City</th>
                                            <th scope="col" class=" py-4">Address</th>
                                            <th scope="col" class=" py-4">Comment</th>
                                            <th scope="col" class=" py-4">Preferred Delivery Date</th>
                                            <th scope="col" class=" py-4">Status</th>
                                            <th scope="col" class=" py-4">Supervisor</th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($orders)
                                            @foreach($orders as $order)
                                                <tr @class([
        'bg-green-300'=>$order->sms_code_confirmation,
        'bg-red-300'=>$order->status==='Invalid'
])
                                                    class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                                                    <td class="whitespace-nowrap  py-4 font-medium">{{$order->policy_number}}</td>
                                                    <td class="whitespace-nowrap  py-4">{{$order->user->order_category->title}}</td>
                                                    <td class="whitespace-nowrap  py-4">{{$order->receiver_name}}</td>
                                                    <td class="whitespace-nowrap  py-4">{{$order->phone_number}}</td>
                                                    <td class="whitespace-nowrap  py-4">{{$order->city->name}}</td>
                                                    <td class="whitespace-nowrap  py-4">{{$order->address}}</td>
                                                    <td class="whitespace-nowrap  py-4">{{$order->comment}}</td>
                                                    <td class="whitespace-nowrap  py-4">{{$order->preferred_delivery_date->format('M d Y')}}</td>
                                                    <td class="whitespace-nowrap  py-4">{{$order->status}}</td>
                                                    <td class="whitespace-nowrap  py-4">{{$order->supervisor}}</td>
                                                    @if($order->status==='Invalid')
                                                        <td class="whitespace-nowrap  py-4">
                                                            <form action="{{route('orders.edit',$order)}}"><x-danger-button>Required Edit</x-danger-button></form>
                                                        </td>

                                                    @endif

                                                </tr>
                                            @endforeach
                                        @endif


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
