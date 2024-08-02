<head>
    <link href="https://vjs.zencdn.net/8.16.1/video-js.css" rel="stylesheet" />

    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <!-- <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script> -->
  </head>

  <body>
    <iframe
        onload="onLoadContent(this)"
        class="content sleek-player"
        id="player_iframe"
        src="//play.webvideocore.net/html5.html"
        allowfullscreen="true"
        allowtransparency="true"
        frameborder="0">
    </iframe>

    <script>
        var playerIframe = document.getElementById('player_iframe');




        function playerInit() {
            sendMessage('init', {
                customUrl: @json($recording->link),
                colorBase: '#250864',
                colorText: '#ffffff',
                colorHover: '#7f54f8',
                threeColorsMode: true,
                playButton: true,
                playButtonStyle: 'pulsing'
            });
        }

        function onMessage(event) {
            if(event.source !== playerIframe.contentWindow) {
                return;
            }

            var key = event.message ? 'message' : 'data';
            var details = event[key];
            var message = details.message;

            if(message === 'init') {
                playerInit();
            }
        }

        function sendMessage(message, data) {
            playerIframe.contentWindow.postMessage({
                message: message,
                data: data
            }, '*');
        }

        playerInit();

        window.addEventListener('message', onMessage, false);
    </script>
  </body>
