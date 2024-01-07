<div style="max-width:700px;margin:auto;">

    <style>
        pre {
            white-space: pre-wrap;       /* Since CSS 2.1 */
            white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
            white-space: -pre-wrap;      /* Opera 4-6 */
            white-space: -o-pre-wrap;    /* Opera 7 */
            word-wrap: break-word;       /* Internet Explorer 5.5+ */
        }
    </style>

    <pre>
PARTICIPANT RELEASE OF LIABILITY ASSUMPTION OF RISK AGREEMENT

*** READ BEFORE SIGNING ***

I, for myself or on behalf of my dependent HEREBY RELEASE, INDEMNIFY, AND HOLD HARMLESS SOUTHSIDE FITNESS LLC its owners, employees, other members, sponsors, advertisers, and, if applicable, owners and lessors of premises, from any and all claims, demands, losses, and liability arising out of or related to any INJURY, DISABILITY OR DEATH. I, or my dependent, may suffer, or loss or damage to person or property, WHETHER ARISING FROM THE NEGLIGENCE OF THE SOUTHSIDE FITNESS LLC OR OTHERWISE, to the fullest extent permitted by law.

Health Statement

I will notify SOUTHSIDE FITNESS LLC ownership or employees if I suffer from any medical or health condition that may cause injury to myself, others, or may require emergency care during my participation.

Media Statement

By signing below, I hereby grant and convey to SOUTHSIDE FITNESS LLC all right, title and interest in and to record my name, image, voice, or statements including any and all photographic images and video or audio recordings made by SOUTHSIDE FITNESS LLC.

I HAVE READ THIS RELEASE OF LIABILITY AND ASSUMPTION OF RISK AGREEMENT, FULLY UNDERSTAND ITS TERMS, UNDERSTAND THAT I HAVE GIVEN UP SUBSTANTIAL RIGHTS BY SIGNING IT, AND SIGN IT FREELY AND VOLUNTARILY WITHOUT ANY INDUCEMENT.
    </pre>

    <ul>
        <li><strong>{{ $member->fullName() }}</strong></li>
    </ul>

    <br />

    <div>
        <canvas width="700" height="200" style="border:1px solid grey;"></canvas>
        <input id="signature" type="hidden" wire:model="signature" />
        <div class="flex flex-row-reverse">
            <button class="mt-2 px-4 py-2 bg-gray-300" wire:click="saveSignature" class="btn btn-primary">Save Signature</button>
        </div>
    </div>

    <br />
    <br />
    <br />
    <br />

</div>

{{--@assets--}}
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
{{--@endassets--}}

{{--@script--}}
<script>
    (function() {
        var canvas = document.querySelector("canvas");
        var signaturePad = new SignaturePad(canvas);
        signaturePad.addEventListener("endStroke", () => {
            Livewire.dispatch('set-signature', { signature: signaturePad.toDataURL() })
        });
    })();
</script>
{{--@endscript--}}
