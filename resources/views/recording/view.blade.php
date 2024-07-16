<script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
<video id="player" playsinline controls data-poster="/path/to/poster.jpg">
    <source src="{{$recording->link}}" type="video/mp4" />
</video>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        const player = new Plyr('#player');
    });
</script>
