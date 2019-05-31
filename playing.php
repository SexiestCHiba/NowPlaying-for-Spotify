<!DOCTYPE html>
<head>
    <title>Spotify Connect - Now Playing</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <link href="playing.css?ts=<?=time ()?>" rel="stylesheet">
    <link href="productsans.css?ts=<?=time ()?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="spotify-web-api.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="scripts.js?ts=<?=time ()?>"></script>
    <script>
    let response;
    let parsedResult;

    function loopForever () {
        setInterval(function() {
            var promise = Promise.resolve(spotifyApi.getMyCurrentPlayingTrack(null));
            promise.then(function(value) {
                response = value;
                console.log(response);
            });

            if (response != "") {
                console.log('Response not empty');
                getInformations();
            } else {
                console.log('Response empty');
                noInformations();
            }

            function getInformations () {
                titleSong = response["item"].name;
                artistSong = response["item"]["album"]["artists"]["0"].name;
                albumSong = response["item"]["album"].name;
                albumPicture = response["item"]["album"]["images"]["0"].url;
                lenghtSong = response["item"].duration_ms;
                lenghtSongFormatted = msToTime(response["item"].duration_ms);
                progressSong = response.progress_ms;
                progressSongFormatted = msToTime(response.progress_ms);
                seekbarProgress = Math.round(progressSong * 100 / lenghtSong);
                $("#playing-div #song-info-div #reconnect-link").attr("style", "display : none");
            }

            function noInformations () {
                titleSong = "Aucune musique en cours de lecture";
                artistSong = "Veuillez patienter quelques secondes pour l'actualisation";
                albumSong = 'Si la page ne fonctionne pas, ';
                albumPicture = "no_song.png";
                lenghtSong = " ";
                lenghtSongFormatted = " ";
                progressSong = " ";
                progressSongFormatted = " ";
                seekbarProgress = 0;
                $("#playing-div #song-info-div #reconnect-link").attr("style", "display : block");
            }
            
            $("#playing-div #song-info-div #song-title").text(titleSong);
            console.log('Updated song');
            $("#playing-div #song-info-div #song-artist").text(artistSong);
            console.log('Updated artist');
            $("#playing-div #song-info-div #song-album").text(albumSong);
            console.log('Updated album');
            $("#playing-div #song-info-div #time-song").text(progressSongFormatted + " · " + lenghtSongFormatted);
            console.log('Updated time')
            $("#playing-div img").attr("src", albumPicture);
            console.log('Updated cover');
            $("#background-image-div").attr("style", "background-image: url('" + albumPicture + "')");
            console.log('Updated background');
            $("#playing-div #song-info-div #seekbar-now").attr("style", "width : " + seekbarProgress + "%");
            console.log('Updated seekbar');

        }, 1000);
    }
    var spotifyApi = new SpotifyWebApi();
    spotifyApi.setAccessToken($_GET('token'));
    loopForever();
    </script>
</head>
<body>
    <div id="playing-div">
        <img src="no_song.png" id="playing-img">
        <div id="song-info-div">
            <h1 id="song-title">Aucune musique en cours de lecture</h1>
            <h2 id="song-artist">Veuillez patienter quelques secondes pour l'actualisation</h2><h2 id="song-album">Si la page ne fonctionne pas, </h2><a id="reconnect-link" href="login.php"><h2>reconnectez-vous</h2></a>
            <div id="seekbar-bg">
                <div id="seekbar-now" style="width : 0%"></div>
            </div>
            <h3 class="left"><i class="material-icons left">speaker</i>Spotify Connect<h3 class="right" id="time-song"></h3>
        </div>
    </div>
    <div id="background-image-div" style="background-image: url('no_song.png')"><div class="darken"></div></div>
</body>