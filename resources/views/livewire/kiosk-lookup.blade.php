<div style="width: 500px;" class="mt-20 flex flex-col justify-center items-start text-2xl">
    <input class="w-full px-6 py-4 border-2" type="text" wire:model.live="search" placeholder="Search">

    @if($search && strlen($search) >= 1)
        <div class="w-full mt-6">
            @foreach(\App\Models\Member::where('first_name', 'like', "%$this->search%")->get() as $member)
                <button class="w-full text-left px-10 py-8 odd:bg-gray-200" wire:click="checkin({{ $member->id }})">
                    {{$member->fullName()}}
                </button>
            @endforeach
        </div>
    @endif

    <div class="h-14 w-full mt-10 text-center text-3xl">
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
