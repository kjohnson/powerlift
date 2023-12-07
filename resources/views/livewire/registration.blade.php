<div class="container w-96 mx-auto p-6">
    <form wire:submit="register">
        <fieldset class="flex flex-col gap-6">
            <legend class="mb-4">Member Details</legend>

            <div class="w-full flex gap-4">
                <div class="flex-1">
                    <label for="firstName" class="block text-sm font-medium leading-6 text-gray-900">First Name</label>
                    <div class="mt-2">
                        <input wire:model="firstName" type="text" name="firstName" id="firstName" class="py-2 pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
            </div>

            <div class="w-full flex gap-4">
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
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register</button>
                </div>
            </div>

        </fieldset>
    </form>
</div>
