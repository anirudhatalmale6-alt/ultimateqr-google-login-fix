{{-- Google One Tap.

     The sign-in prompt that appears in the corner of the screen. Shown only to
     visitors who are not already signed in.

     Two switches in .env control it:
       GOOGLE_ENABLE=on    shared with the Sign in with Google buttons
       GOOGLE_ONE_TAP=on   this popup only - remove it and the buttons stay

     Nothing here is trusted. Google gives the browser a signed token, the
     browser posts it to /google-one-tap, and the site checks Google's
     signature on it before signing anyone in. --}}
@guest
@if (env('GOOGLE_ENABLE') == 'on' && env('GOOGLE_ONE_TAP') == 'on' && env('GOOGLE_CLIENT_ID'))

<div id="g_id_onload"
    data-client_id="{{ env('GOOGLE_CLIENT_ID') }}"
    data-callback="petaqrOneTap"
    data-context="signup"
    data-auto_select="false"
    data-cancel_on_tap_outside="false"
    data-itp_support="true"></div>

<script>
    // Google calls this with the signed token once the visitor picks their
    // account in the prompt.
    function petaqrOneTap(response) {
        if (!response || !response.credential) {
            return;
        }

        fetch("{{ route('google.onetap') }}", {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ credential: response.credential })
        })
        .then(function (r) {
            return r.json().catch(function () {
                return null;
            });
        })
        .then(function (data) {
            if (data && data.ok && data.redirect) {
                window.location.assign(data.redirect);
                return;
            }

            // Nothing is shown to the visitor on purpose. The Sign in with
            // Google button is still on the page and still works, so a failed
            // popup costs them nothing. The reason is written to
            // storage/logs/laravel.log tagged GOOGLE-ONE-TAP.
            console.warn("One Tap sign-in was not accepted:", data && data.error);
        })
        .catch(function (e) {
            console.warn("One Tap sign-in could not reach the site:", e);
        });
    }
</script>

<script src="https://accounts.google.com/gsi/client" async defer></script>

@endif
@endguest
