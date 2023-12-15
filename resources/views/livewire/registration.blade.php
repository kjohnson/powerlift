<div class="container w-96 mx-auto p-6">
    <form wire:submit="register">

        {{-- STEP 1 --}}
        @if ($currentStep == 1)
            <fieldset class="flex flex-col gap-6">
                <legend class="mb-4">Member Details</legend>

                <div class="w-full flex gap-4">
                    <div class="flex-1">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                        <div class="mt-2">
                            <input wire:model="name" type="text" name="name" id="name" class="py-2 pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </div>

                <div class="w-full flex gap-4">
                    <div class="flex-1">
                        <label for="emailAddress" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-2">
                            <input wire:model="emailAddress" type="email" name="emailAddress" id="emailAddress" class="py-2  pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </div>

                <div class="w-full flex gap-4">
                    <div class="flex-1">
                        <label for="emailAddress" class="block text-sm font-medium leading-6 text-gray-900">Phone Number</label>
                        <div class="mt-2">
                            <input wire:model="phoneNumber" type="phone" name="phoneNumber" id="phoneNumber" class="py-2  pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </div>

                <div class="w-full flex gap-4">
                    <div class="flex-1">
                        <button wire:click="nextStep" type="button" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Continue</button>
                    </div>
                </div>
            </fieldset>
        @endif

        {{-- STEP 2 --}}
        @if ($currentStep == 2)
            <fieldset class="flex flex-col gap-6">
                <legend class="mb-4">Payment Details</legend>

                <div class="w-full flex gap-4">
                    <div class="flex-1">
                        <label for="creditCardNumber" class="block text-sm font-medium leading-6 text-gray-900">Card Number</label>
                        <div class="mt-2">
                            <input wire:model="creditCardNumber" type="text" name="creditCardNumber" id="creditCardNumber" class="py-2 pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </div>

                <div class="w-full flex gap-4">
                    <div class="flex-1">
                        <button wire:click="register" type="button" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Continue</button>
                    </div>
                </div>

            </fieldset>
        @endif

        {{-- STEP 3 --}}
        @if ($currentStep == 3)
            <fieldset class="flex flex-col gap-6">
                <legend class="mb-4">Billing Address</legend>

                <div class="w-full flex gap-4">
                    <div class="flex-1">
                        <label for="addressStreet" class="block text-sm font-medium leading-6 text-gray-900">Street Address</label>
                        <div class="mt-2">
                            <input wire:model="addressStreet" type="text" name="addressStreet" id="addressStreet" class="py-2 pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </div>

                <div class="w-full flex gap-4">
                    <div class="flex-1">
                        <label for="addressCity" class="block text-sm font-medium leading-6 text-gray-900">City</label>
                        <div class="mt-2">
                            <input wire:model="addressCity" type="text" name="addressCity" id="addressCity" class="py-2 pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </div>

                <div class="w-full flex gap-4">
                    <div class="flex-1">
                        <label for="addressState" class="block text-sm font-medium leading-6 text-gray-900">State</label>
                        <div class="mt-2">
                            <input wire:model="addressState" type="text" name="addressState" id="addressState" class="py-2 pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </div>

                <div class="w-full flex gap-4">
                    <div class="flex-1">
                        <label for="addressZip" class="block text-sm font-medium leading-6 text-gray-900">Zip Code</label>
                        <div class="mt-2">
                            <input wire:model="addressZip" type="text" name="addressZip" id="addressZip" class="py-2 pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </div>

                <div class="w-full flex gap-4">
                    <div class="flex-1">
                        <button wire:click="nextStep" type="button" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Complete Registration</button>
                    </div>
                </div>
            </fieldset>
        @endif
    </form>
</div>
