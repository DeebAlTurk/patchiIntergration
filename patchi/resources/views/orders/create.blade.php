<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Adding Order') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="w-1/2 mx-auto sm:px-6 lg:px-8s">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('orders.store')}}" class="mx-auto w-100" method="post">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="policy_number" class="my-2" required>Policy Number</x-input-label>
                            <x-text-input value="{{old('policy_number')}}" type="text" id="policy_number" name="policy_number"
                                          class="w-full"></x-text-input>
                            <x-input-error :messages="$errors->get('policy_number')"></x-input-error>

                        </div>

                        <div class="mb-4">
                            <x-input-label for="receiver_name" class="my-2" required>Receiver Name</x-input-label>
                            <x-text-input value="{{old('receiver_name')}}" type="text" id="receiver_name" name="receiver_name"
                                          class="w-full"></x-text-input>
                            <x-input-error :messages="$errors->get('receiver_name')"></x-input-error>

                        </div>


                        <!-- Phone Number -->
                        <div class="mb-4">
                            <x-input-label for="phone_number" class="my-2">Phone Number</x-input-label>
                            <x-text-input  value="{{old('phone_number')}}" required  type="tel" id="phone_number" name="phone_number" placeholder="966xxxxxxxx" class="w-full"></x-text-input>
                            <x-input-error :messages="$errors->get('phone_number')"></x-input-error>

                        </div>

                        <!--  Select -->
                        <div class="mb-4">
                            <label for="district_id" class="my-2 block text-sm font-medium dark:text-white">District</label>
                            <select required id="district_id" name="district_id"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach($districts as $district)
                                    <option @selected(old('district_id') == $district->id) value="{{$district->id}}">{{$district->city->name}} - {{$district->name}}</option>
                            @endforeach
                                <!-- Add more options as needed -->
                            </select>
                            <x-input-error :messages="$errors->get('district_id')"></x-input-error>

                        </div>
                        <!--  Select -->
                        <div class="mb-4">
                            <label for="delivery_providers_id" class="my-2 block text-sm font-medium dark:text-white">Delivery Provider</label>
                            <select required id="delivery_providers_id" name="delivery_providers_id"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach($deliveryProviders as $provider)
                                    <option @selected(old('delivery_providers_id') == $provider->id) value="{{$provider->id}}">{{$provider->title}}</option>
                            @endforeach
                            <!-- Add more options as needed -->
                            </select>
                            <x-input-error :messages="$errors->get('delivery_providers_id')"></x-input-error>

                        </div>

                        <!-- Full Address Text Area -->
                        <div class="mb-4">
                            <x-input-label class="my-2" for="address">Full Address</x-input-label>
                            <x-text-input value="{{old('address')}}" required type="text" id="address" name="address" class="w-full"></x-text-input>
                            <x-input-error :messages="$errors->get('address')"></x-input-error>

                        </div>
                        <div class="mb-4">
                            <x-input-label class="my-2" for="preferred_delivery_date">Preferred Delivery Date</x-input-label>
                            <input type="datetime-local" value="{{old('preferred_delivery_date')}}" required  id="preferred_delivery_date" name="preferred_delivery_date" class="w-full">
                            <x-input-error  :messages="$errors->get('preferred_delivery_date')"></x-input-error>
                        </div>

                        <div class="mb-4">
                            <x-input-label class="my-2" for="comment">Comment</x-input-label>
                            <x-text-input  value="{{old('comment')}}" type="text" id="comment" name="comment" class="w-full"></x-text-input>
                            <x-input-error :messages="$errors->get('comment')"></x-input-error>

                        </div>

                        <!-- Add more fields as needed -->

                       <div class="flex flex-col items-center">
                           <x-primary-button class="mx-auto">Submit</x-primary-button>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
