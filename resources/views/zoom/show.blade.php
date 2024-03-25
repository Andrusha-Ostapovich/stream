<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Meeting Zoom') }}
        </h2>
    </x-slot>
    <br>

    <main>
        <h1>Zoom Meeting SDK Sample JavaScript</h1>

        <!-- For Component View -->
        <div id="meetingSDKElement">
            <!-- Zoom Meeting SDK Rendered Here -->
        </div>

        <button onclick="getSignature()">Join Meeting</button>
    </main>

    <!-- Dependencies for client view and component view -->


    <style>
        html,
        body {
            min-width: 0 !important;
        }

        #zmmtg-root {
            display: none;
            min-width: 0 !important;
        }

        main {
            width: 70%;
            margin: auto;
            text-align: center;
        }

        main button {
            margin-top: 20px;
            background-color: #2D8CFF;
            color: #ffffff;
            text-decoration: none;
            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 40px;
            padding-right: 40px;
            display: inline-block;
            border-radius: 10px;
            cursor: pointer;
            border: none;
            outline: none;
        }

        main button:hover {
            background-color: #2681F2;
        }
    </style>
      <script src="https://source.zoom.us/3.1.6/lib/vendor/react.min.js"></script>
      <script src="https://source.zoom.us/3.1.6/lib/vendor/react-dom.min.js"></script>
      <script src="https://source.zoom.us/3.1.6/lib/vendor/redux.min.js"></script>
      <script src="https://source.zoom.us/3.1.6/lib/vendor/redux-thunk.min.js"></script>
      <script src="https://source.zoom.us/3.1.6/lib/vendor/lodash.min.js"></script>

      <!-- For Client View -->
      <script src="https://source.zoom.us/zoom-meeting-3.1.6.min.js"></script>
      <script type="text/javascript" src="client-view.js"></script>

    {{-- <script src="https://source.zoom.us/zoom-meeting-3.1.6.min.js"></script>
    <script src="https://source.zoom.us/3.1.6/zoom-meeting-embedded-3.1.6.min.js"></script> --}}


    {{-- <script>
        const client = ZoomMtgEmbedded.createClient()

        let meetingSDKElement = document.getElementById('meetingSDKElement')

        var authEndpoint = 'http://localhost:4000';
        var sdkKey = 'vMtrzb6Atn1vQq4EdOOqPzarTgG5MM5s';
        var meetingNumber = "{{ $meeting['data']['id'] }}";
        var passWord = "{{ $meeting['data']['password'] }}";
        var role = "0";
        var userName = 'Dises'
        var userEmail = 'andrii.ostapovich@gmail.com'
        var registrantToken = ''
        var zakToken = ''

        function getSignature() {
            fetch(authEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    meetingNumber: meetingNumber,
                    role: role
                })
            }).then((response) => {
                return response.json()
            }).then((data) => {
                console.log(data)
                startMeeting(data.signature)
                // startMeeting("{{ $signature }}")
            }).catch((error) => {
                console.log(error)
            })
        }


        function startMeeting(signature) {
            console.log(sdkKey);
            console.log(meetingNumber);
            console.log(passWord);
            console.log(userName);
            client.init({
                zoomAppRoot: meetingSDKElement,
                language: 'en-US',
                patchJsMedia: true
            }).then(() => {
                client.join({
                    sdkKey: sdkKey,
                    signature: signature,
                    userName: userName,
                    meetingNumber: meetingNumber,
                    password: passWord
                }).then(() => {
                    console.log('joined successfully')
                }).catch((error) => {
                    console.log(error)
                })
            }).catch((error) => {
                console.log(error)
            })
        }
    </script> --}}
    <script>
        ZoomMtg.preLoadWasm()
        ZoomMtg.prepareWebSDK()

        var authEndpoint = 'http://localhost:4000';
        var sdkKey = 'w8L64HRT1yOpTdF6B7zKg'
        var meetingNumber = "{{ $meeting['data']['id'] }}";
        var passWord = "{{ $meeting['data']['password'] }}";
        var role = 0
        var userName = 'JavaScript'
        var userEmail = ''
        var registrantToken = ''
        var zakToken = ''
        var leaveUrl = 'https://zoom.us'

        function getSignature() {
            fetch(authEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    meetingNumber: meetingNumber,
                    role: role
                })
            }).then((response) => {
                return response.json()
            }).then((data) => {
                console.log(data)
                startMeeting(data.signature)
            }).catch((error) => {
                console.log(error)
            })
        }

        function startMeeting(signature) {

            document.getElementById('meetingSDKElement').style.display = 'block'

            ZoomMtg.init({
                leaveUrl: leaveUrl,
                patchJsMedia: true,
                success: (success) => {
                    console.log(success)
                    ZoomMtg.join({
                        signature: signature,
                        sdkKey: sdkKey,
                        meetingNumber: meetingNumber,
                        passWord: passWord,
                        userName: userName,
                        userEmail: userEmail,
                        // tk: registrantToken,
                        // zak: zakToken,
                        success: (success) => {
                            console.log(success)
                        },
                        error: (error) => {
                            console.log(error)
                        },
                    })
                },
                error: (error) => {
                    console.log(error)
                }
            })
        }
    </script>


</x-app-layout>
