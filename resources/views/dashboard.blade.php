<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    @vite('resources/js/app.js')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <body>
                <video id="localVideo" autoplay></video>
                <video id="remoteVideo" autoplay></video>
                <button style="color: rgb(27, 23, 23) ;background-color: #60fa7c;" id="startButton">Start Video Call
                </button>

            </body>

            <script>
                const configuration = {
                    iceServers: [{
                        urls: 'stun:stun.l.google.com:19302'
                    }]
                };

                const startButton = document.querySelector('#startButton');
                startButton.addEventListener('click', startVideoCall);

                let localStream;
                let peerConnection;

                async function startVideoCall() {
                    try {
                        localStream = await openMediaDevices({
                            'video': true,
                            'audio': true
                        });

                        const localVideoElement = document.querySelector('#localVideo');
                        localVideoElement.srcObject = localStream;

                        peerConnection = new RTCPeerConnection(configuration);

                        // Add tracks from local stream to peer connection
                        localStream.getTracks().forEach(track => {
                            peerConnection.addTrack(track, localStream);
                        });

                        // Create offer
                        const offer = await peerConnection.createOffer();
                        await peerConnection.setLocalDescription(offer);

                        // Send offer to the server
                        await sendOfferToServer(offer);

                    } catch (error) {
                        console.error('Error starting video call:', error);
                    }
                }

                async function openMediaDevices(constraints) {
                    return await navigator.mediaDevices.getUserMedia(constraints);
                }

                async function sendOfferToServer(offer) {
                    try {
                        // Send offer to the server via POST request
                        const response = await fetch('/stream-offer', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                offer: offer
                            })
                        });

                        if (response.ok) {
                            console.log('Offer sent successfully');
                        } else {
                            console.error('Failed to send offer');
                        }
                    } catch (error) {
                        console.error('Error sending offer:', error);
                    }
                }

                // Listen for incoming offers via WebSocket
                $(document).ready(function() {
                    window.Echo.channel('stream-signal-channel.{{ Auth::id() }}')
                        .listen('OfferEvent', (data) => {
                            const offer = new RTCSessionDescription(data.offer);
                            handleIncomingOffer(offer);
                        });
                });


                function handleIncomingOffer(offer) {
                    // Set remote description and create answer
                    peerConnection.setRemoteDescription(offer)
                        .then(() => peerConnection.createAnswer())
                        .then(answer => peerConnection.setLocalDescription(answer))
                        .then(() => {
                            // Send answer to the server
                            sendAnswerToServer(peerConnection.localDescription);
                        })
                        .catch(error => console.error('Error handling incoming offer:', error));
                }

                async function sendAnswerToServer(answer) {
                    try {
                        // Send answer to the server via POST request
                        const response = await fetch('/stream-answer', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                answer: answer
                            })
                        });

                        if (response.ok) {
                            console.log('Answer sent successfully');
                        } else {
                            console.error('Failed to send answer');
                        }
                    } catch (error) {
                        console.error('Error sending answer:', error);
                    }
                }
            </script>


            </html>
        </div>
    </div>
    </div>
</x-app-layout>
