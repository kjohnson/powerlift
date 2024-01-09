<div>
    <div class="relative z-10 flex flex-col w-screen" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!--
          Background backdrop, show/hide based on modal state.

          Entering: "ease-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="cursor-none flex min-h-full items-end p-4 text-center sm:items-center sm:p-0">

                <div class="w-3/4 flex flex-col items-center">
                    <!--
BARBELL SQUAT ANIMATION
-->
                    <div style="width: 500px;">
                        <img id="squatAnimation" src="{{ asset('assets/squat1.png') }}" alt="">
                    </div>

                    <!--
RFID SCANNER NOTICE
-->
                    <div class="w-1/2 relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8">

                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                                        {{ $message ?: 'Check In'}}
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Scan your RFID chip to check in.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <!--
                SCHEDULE
                -->
                <div class="w-1/3 px-20 mt-10 self-start">
                    <ul class="flex flex-col gap-6">
                        @foreach($sessions as $session)
                            <li>
                                <div class="bg-white rounded-lg p-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                                                {{ $session->fitnessClass->name }}
                                            </h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">{{$session->start_time->toDayDateTimeString()}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/onscan/onscan.min.js') }}"></script>
    <script>
        (function() {
            onScan.attachTo(document, {
                suffixKeyCodes: [13], // enter-key expected at the end of a scan
                reactToPaste: true, // Compatibility to built-in scanners in paste-mode (as opposed to keyboard-mode)
                onScan: function(sCode, iQty) { // Alternative to document.addEventListener('scan')
                    console.log("Scanned " + sCode)
                    Livewire.dispatch('scan', { code: sCode })
                    scheduleReset();
                    startSquatAnimation();
                },
            });

            let resetTimeout;
            const scheduleReset = () => {
                clearTimeout(resetTimeout)
                resetTimeout = setTimeout(function() {
                    console.log('RESET');
                    Livewire.dispatch('reset')
                }, 5000)
            }

             window.startSquatAnimation = function() {
                setTimeout(function() {
                    document.getElementById('squatAnimation').src = "{{ asset('assets/squat2.png') }}"
                    setTimeout(function() {
                        document.getElementById('squatAnimation').src = "{{ asset('assets/squat3.png') }}"
                        setTimeout(function() {
                            document.getElementById('squatAnimation').src = "{{ asset('assets/squat4.png') }}"
                            setTimeout(function() {
                                document.getElementById('squatAnimation').src = "{{ asset('assets/squat1.png') }}"
                            }, 500)
                        }, 500)
                    }, 500)
                }, 500)
            }
            startSquatAnimation();
        })()
    </script>
</div>
