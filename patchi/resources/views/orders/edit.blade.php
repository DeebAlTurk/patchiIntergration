<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Order')  }} {{$order->policy_number}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="w-1/2 mx-auto sm:px-6 lg:px-8s">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('orders.update',$order)}}" class="mx-auto w-100" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <x-input-label for="policy_number" class="my-2" required>Policy Number</x-input-label>
                            <x-text-input value="{{$order->policy_number}}" type="text" id="policy_number" name="policy_number"
                                          class="w-full"></x-text-input>
                            <x-input-error :messages="$errors->get('policy_number')"></x-input-error>

                        </div>

                        <div class="mb-4">
                            <x-input-label for="receiver_name" class="my-2" required>Receiver Name</x-input-label>
                            <x-text-input value="{{$order->receiver_name}}" type="text" id="receiver_name" name="receiver_name"
                                          class="w-full"></x-text-input>
                            <x-input-error :messages="$errors->get('receiver_name')"></x-input-error>

                        </div>


                        <!-- Phone Number -->
                        <div class="mb-4">
                            <x-input-label for="phone_number" class="my-2">Phone Number</x-input-label>
                            <x-text-input  value="{{$order->phone_number}}" required  type="tel" id="phone_number" name="phone_number" class="w-full"></x-text-input>
                            <x-input-error :messages="$errors->get('phone_number')"></x-input-error>

                        </div>

                        <!-- City Select -->
                        <div class="mb-4">
                            <label for="city_id" class="my-2 block text-sm font-medium dark:text-white">City</label>
                            <select required id="city_id" name="city_id"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach($cities as $city)
                                    <option @selected($order->city_id == $city->id) value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                                <!-- Add more options as needed -->
                            </select>
                            <x-input-error :messages="$errors->get('city_id')"></x-input-error>

                        </div>

                        <!-- Full Address Text Area -->
                        <div class="mb-4">
                            <x-input-label class="my-2" for="address">Full Address</x-input-label>
                            <x-text-input value="{{$order->address}}" required type="text" id="address" name="address" class="w-full"></x-text-input>
                            <x-input-error :messages="$errors->get('address')"></x-input-error>

                        </div>
                        <div class="mb-4">
                            <x-input-label class="my-2" for="preferred_delivery_date">Preferred Delivery Date</x-input-label>
                            <input type="datetime-local" value="{{$order->preferred_delivery_date}}" required  id="preferred_delivery_date" name="preferred_delivery_date" class="w-full">
                            <x-input-error  :messages="$errors->get('preferred_delivery_date')"></x-input-error>
                        </div>

                        <div class="mb-4">
                            <x-input-label class="my-2" for="comment">Comment</x-input-label>
                            <x-text-input  value="{{$order->comment}}" type="text" id="comment" name="comment" class="w-full"></x-text-input>
                            <x-input-error :messages="$errors->get('comment')"></x-input-error>

                        </div>
                       <div class="flex flex-col items-center">
                           <x-primary-button class="mx-auto">Submit</x-primary-button>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
