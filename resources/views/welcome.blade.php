<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel</title>
</head>

<body>
    <h1>Laravel</h1>
    <video id="localVideo" autoplay muted></video>
    <video id="remoteVideo" autoplay></video>
    <button id="startButton">Start</button>

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
    let sendChannel;
    let receiveChannel;

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

            // Create data channel
            sendChannel = peerConnection.createDataChannel('sendDataChannel');
            sendChannel.onopen = handleSendChannelStatusChange;
            sendChannel.onclose = handleSendChannelStatusChange;

            // Set up event listener to receive data channel messages
            peerConnection.ondatachannel = receiveDataChannel;

            // Create offer
            const offer = await peerConnection.createOffer();
            await peerConnection.setLocalDescription(offer);

            // Set up listener for ICE candidate events
            peerConnection.onicecandidate = handleIceCandidate;

            // Send offer to the remote peer
            sendOffer(offer);
        } catch (error) {
            console.error('Error starting video call:', error);
        }
    }

    async function openMediaDevices(constraints) {
        return await navigator.mediaDevices.getUserMedia(constraints);
    }

    function handleSendChannelStatusChange(event) {
        if (sendChannel) {
            const readyState = sendChannel.readyState;
            console.log('Send channel state is: ' + readyState);
            // Enable/disable the textarea based on the channel state
            document.getElementById('dataChannelSend').disabled = (readyState !== 'open');
        }
    }

    function receiveDataChannel(event) {
        receiveChannel = event.channel;
        receiveChannel.onmessage = handleReceiveMessage;
        receiveChannel.onopen = handleReceiveChannelStatusChange;
        receiveChannel.onclose = handleReceiveChannelStatusChange;
    }

    function handleReceiveChannelStatusChange(event) {
        if (receiveChannel) {
            const readyState = receiveChannel.readyState;
            console.log('Receive channel state is: ' + readyState);
            // Enable/disable the textarea based on the channel state
            document.getElementById('dataChannelReceive').disabled = (readyState !== 'open');
        }
    }

    function handleReceiveMessage(event) {
        console.log('Received message:', event.data);
        document.getElementById('dataChannelReceive').value = event.data;
    }

    async function handleIceCandidate(event) {
        if (event.candidate) {
            // Send the candidate to the remote peer
            console.log('Sending ICE candidate to the remote peer:', event.candidate);
        }
    }

    function sendOffer(offer) {
        // Here you should send the offer to the remote peer (via signaling server or other means)
        // For simplicity, we will just log the offer to the console
        console.log('Offer:', offer);
    }
</script>

</html>
