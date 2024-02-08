<div class="flex flex-col items-center gap-6">
    <div class="h-14 text-3xl">
        {{$this->pinAsPassword()}}
    </div>

    <div style="width: 415px;" class="grid grid-cols-3 gap-4">
        <button class="h-32 w-32 rounded-lg bg-gray-500 text-white text-3xl" wire:click="input(1)">1</button>
        <button class="h-32 w-32 rounded-lg bg-gray-500 text-white text-3xl" wire:click="input(2)">2</button>
        <button class="h-32 w-32 rounded-lg bg-gray-500 text-white text-3xl" wire:click="input(3)">3</button>

        <button class="h-32 w-32 rounded-lg bg-gray-500 text-white text-3xl" wire:click="input(4)">4</button>
        <button class="h-32 w-32 rounded-lg bg-gray-500 text-white text-3xl" wire:click="input(5)">5</button>
        <button class="h-32 w-32 rounded-lg bg-gray-500 text-white text-3xl" wire:click="input(6)">6</button>

        <button class="h-32 w-32 rounded-lg bg-gray-500 text-white text-3xl" wire:click="input(7)">7</button>
        <button class="h-32 w-32 rounded-lg bg-gray-500 text-white text-3xl" wire:click="input(8)">8</button>
        <button class="h-32 w-32 rounded-lg bg-gray-500 text-white text-3xl" wire:click="input(9)">9</button>

        <button class="h-32 w-32 rounded-lg bg-gray-300 text-black text-3xl" wire:click="backspace">←</button>
        <button class="h-32 w-32 rounded-lg bg-gray-500 text-white text-3xl" wire:click="input(0)">0</button>
        <button class="h-32 w-32 rounded-lg bg-gray-300 text-black text-3xl"  wire:click="clear">𐄂</button>
    </div>

    <div class="h-14 text-3xl">
        <div id="message">{{ $message }}</div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('flash-message', () => {
            setTimeout(() => {
                Livewire.dispatch('reset')
            }, 3000)
        })
    })
</script>
