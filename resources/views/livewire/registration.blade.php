<div class="container w-96 mx-auto p-6">
    <form wire:submit="register">

        {{-- STEP 1 --}}
        @if ($currentStep == 1)
            <fieldset class="flex flex-col gap-6">
                <legend class="mb-4">Member Details</legend>

                <div class="w-full flex gap-4">
                    <div class="flex-1">
                        <label for="firstName" class="block text-sm font-medium leading-6 text-gray-900">First Name</label>
                        <div class="mt-2">
                            <input wire:model="firstName" type="text" name="firstName" id="firstName" class="py-2 pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div class="flex-1">
                        <label for="lastName" class="block text-sm font-medium leading-6 text-gray-900">Last Name</label>
                        <div class="mt-2">
                            <input wire:model="lastName" type="text" name="lastName" id="lastName" class="py-2 pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                    <div class="flex-3">
                        <label for="creditCardExpiration" class="block text-sm font-medium leading-6 text-gray-900">Expiration</label>
                        <div class="mt-2">
                            <input wire:model="creditCardExpiration" type="text" name="creditCardExpiration" id="creditCardExpiration" class="py-2 pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div class="flex-3">
                        <label for="creditCardCVV" class="block text-sm font-medium leading-6 text-gray-900">CCV</label>
                        <div class="mt-2">
                            <input wire:model="creditCardCVV" type="text" name="creditCardCVV" id="creditCardCVV" class="py-2 pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
            Thanks for registering! See you at the gym.
        @endif

    </form>
</div>
