<?php
/*
Template Name: Podcasts Page
*/
get_header();
use \Config\Config;

global $wpdb;
$table_posts = 'wp_posts';
$table_podcasts = \Config\Config::TABLE_WP_FX_PODCASTS;
$table_tokens = \Config\Config::TABLE_WP_FX_TOKENS;
$tokens = $wpdb->get_results("SELECT access_token FROM `$table_tokens` LIMIT 1");
$access_token = $tokens[0]->access_token;
$podcasts = $wpdb->get_results("SELECT pd.id, pd.track_name, pd.artist_name, pd.track_release_date, pd.album_image, pd.track_uri, pd.track_duration_ms, ps.guid FROM `$table_podcasts` as pd LEFT JOIN `$table_posts` as ps ON pd.post_id = ps.id ORDER BY `created_at` DESC LIMIT 4");
?>
<div class="fx-podcast-header-main">
    <div class="fx-latest-podcasts-slides-wrapper" >
        <ul class="list-inline owl-carousel owl-theme owl-loaded owl-drag" id="fx-podcast-owl-carousel">
            <?php foreach ($podcasts as $podcast) { ?>
                <li>
                    <div class="fx-latest-podcasts-slide-item">
                        <a href="<?php echo $podcast->guid ?>">
                            <div class="fx-podcast-slide-item-img"
                                 style='background-image: url("<?php echo plugin_dir_url(dirname(__FILE__, 1)) . Config::FX_PODCAST_IMAGES_DIR_BIG . $podcast->album_image ?>");'>
                                <div class="fx-podcasts-shadow-effect"></div>
                            </div>
                            <div class="fx-podcast-slide-item-title">
                                <?php echo $podcast->track_name ?>
                            </div>
                            <div class="fx-podcast-slide-item-author">
                                Radio Name
                            </div>
                        </a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<div id="fx-share-modal-btn"></div>
<div class="fx-latest-podcasts-wrapper">
    <div class="container-fluid">
        <div class="fx-latest-podcasts-heading">
            <div class="fx-latest-podcasts-heading-title fx-latest-podcasts-heading-text-blocks">
                LATEST PODCASTS
            </div>
            <div class="fx-latest-podcasts-heading-sort fx-latest-podcasts-heading-text-blocks">
                <!--                    Sort by: Upcoming-->
                <!--                    <span><i class="fa fa-angle-down"></i></span>-->
            </div>
        </div>
        <div class="fx-latest-podcasts-body">
            <div class="container">
                <ul>
                    <?php foreach ($podcasts as $key => $podcast) { ?>
                        <li>
                            <div class="fx-latest-podcast-body-card fx-latest-podcast-body-card-<?php echo $podcast->id ?>">
                                <div class="row fx-latest-podcast-body-card-content-row">
                                    <div class="col-sm-11">
                                        <div class="fx-latest-podcast-body-card-content">
                                            <div class="row ">
                                                <div class="col-sm-2 fx-latest-podcast-body-card-img-wrapper">
                                                    <div class="fx-latest-podcast-body-card-img">
                                                        <img width="128" height="128"
                                                             src="<?php echo plugin_dir_url(dirname(__FILE__, 1)) . Config::FX_PODCAST_IMAGES_DIR_MEDIUM . $podcast->album_image ?>"
                                                             class="" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-sm-8 fx-latest-podcast-body-card-info-wrapper">
                                                    <a href="<?php echo $podcast->guid ?>">
                                                        <div class="fx-latest-podcast-body-card-title">
                                                            <?php echo $podcast->track_name ?>
                                                        </div>
                                                        <div class="fx-latest-podcast-body-card-description">
                                                            Contrary to popular belief. Richard McClintock, a Latin
                                                            professor at Hampden-Sydney College in Virginia, looked
                                                            up one of. professor at Hampden-Sydney College in
                                                            Virginia, looked
                                                            up one of.
                                                        </div>
                                                        <div class="fx-latest-podcast-body-card-author fx-latest-podcast-body-card-meta">
                                                            <?php echo $podcast->artist_name ?>
                                                        </div>
                                                        <div class="fx-latest-podcast-body-card-dot fx-latest-podcast-body-card-meta">
                                                            &bull;
                                                        </div>
                                                        <div class="fx-latest-podcast-body-card-duration fx-latest-podcast-body-card-meta">
                                                            <?php echo \Inc\Helpers\DateHelper::convertTrackMsDurationToMinute($podcast->track_duration_ms) ?>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-md-2 col-sm-2">
                                                    <div class="row d-flex align-items-center h-100 fx-latest-podcast-body-card-actions">
                                                            <span class="col-12 d-flex fx-latest-podcast-body-card-play-actions">
                                                                    <span class="d-inline-flex justify-content-center align-items-center rounded-circle fx-latest-podcast-body-card-actions-play-icon fx-player-control-icons"
                                                                          id="fx-player-next-<?php echo $key ?>"
                                                                          data-uri="<?php echo $podcast->track_uri ?>"
                                                                          data-id="<?php echo $podcast->id ?>">
                                                                        <i class="fa fa-play fa-xs fx-player-play-btns fx-player-main-btns-<?php echo $podcast->id ?> fx-player-main-play-<?php echo $podcast->id ?>"
                                                                           aria-hidden="true"></i>
                                                                        <i class="fa fa-pause fa-xs fx-player-plause-btns fx-player-main-btns-<?php echo $podcast->id ?> fx-player-main-pause-<?php echo $podcast->id ?>"
                                                                           aria-hidden="true" style="display: none"></i>

                                                                    </span>
                                                                    <span class="d-inline-flex justify-content-center align-items-center rounded-circle fx-latest-podcast-body-card-actions-share-icon share-btn"
                                                                          data-link="<?php echo $podcast->guid ?>">
                                                                        <i class="fa fa-share-alt fa-xs"
                                                                           aria-hidden="true"></i>
                                                                    </span>
                                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row fx-latest-podcast-body-card-content-player latest-podcast-player-<?php echo $podcast->id ?>">
                                                <div class="col-sm-2 d-flex align-items-center player-btns">
                                                        <span class="col-sm-4 player-btns-backward"
                                                              data-prev="<?php echo $key - 1 ?>">
                                                            <i class="fas fa-step-backward fa-xs"
                                                               aria-hidden="true"></i>
                                                        </span>
                                                    <span class="col-sm-4 opened-player-control-btns"
                                                          id="opened-player-control-btns-<?php echo $podcast->id ?>"
                                                          data-id="<?php echo $podcast->id ?>">
                                                                <i class="fa fa-pause fa-xs fx-player-seconde-btns-pause fx-player-seconde-btns-<?php echo $podcast->id ?>"
                                                                   id="fx-player-second-btn-pause-<?php echo $podcast->id ?>"
                                                                   aria-hidden="true"></i>
                                                                <i class="fa fa-play fa-xs fx-player-seconde-btns-play fx-player-seconde-btns-<?php echo $podcast->id ?>"
                                                                   id="fx-player-second-btn-play-<?php echo $podcast->id ?>"
                                                                   aria-hidden="true"></i>
                                                            </span>
                                                    <span class="col-sm-4 fa-xs player-btns-forward"
                                                          data-next="<?php echo $key + 1 ?>">
                                                                <i class="fas fa-step-forward" aria-hidden="true"></i>
                                                            </span>
                                                </div>
                                                <div class="col-sm-10 d-flex align-items-center player-range-wrapper">
                                                        <span class="col-sm-1 text-center player-range-start-time fx-player-start-time-<?php echo $podcast->id ?>">
                                                            00:00
                                                        </span>
                                                    <span class="col-sm-8 d-flex align-items-center">
                                                            <input type="range" min="0" max="0" value="0" step="1"
                                                                   class="podcast-player-trace-<?php echo $podcast->id ?> podcast-player-trace player-trace"
                                                                   data-seconds="<?php echo \Inc\Helpers\DateHelper::convertTrackMsDurationToSecond($podcast->track_duration_ms) ?>"
                                                                   data-id="<?php echo $podcast->id ?>">
                                                        </span>
                                                    <span class="col-sm-1 text-center player-range-end-time">
                                                            <?php echo \Inc\Helpers\DateHelper::convertTrackMsDurationToMinute($podcast->track_duration_ms) ?>
                                                        </span>
                                                    <span class="col-sm-2 d-flex align-items-center player-volume-wrapper">
                                                            <span class="col-sm-2  player-volume-icon">
                                                                <i class="fas fa-volume-up"></i>
                                                            </span>
                                                            <span class="col-sm-10 d-flex align-items-center">
                                                                <input type="range" min="0" max="1" value="0"
                                                                       step="0.001"
                                                                       class="player-volume-range-style player-volume-range-jq">
                                                            </span>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>
<script src="https://sdk.scdn.co/spotify-player.js"></script>
<script type="text/javascript">
    (function ($) {
        "use strict";
        $(document).ready(function () {

            $('#fx-podcast-owl-carousel').owlCarousel({
                autoWidth: true,
                autoHeigth: true,
                center: true,
                margin: 0,
                loop: true,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                items: 3,
                dots: true,
                navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
                nav: true,
            });
            $('#fx-podcast-owl-carousel').owlCarousel();
            $('#fx-podcast-owl-carousel').css('visibility', 'visible');
        });
    })(jQuery);

    $(".share-btn").on("click", function () {
        let link = $(this).attr('data-link');
        let uri = "<?php echo plugin_dir_url(dirname(__FILE__, 1)) . 'templates/modal.php'?>";
        $.ajax({
            url: uri,
            type: 'GET',
            success: function (data) {
                $('#fx-share-modal-btn').html(data);
                $("#share-modal").modal('show');
                $('#fx-modal-copy-input').val(link);
            },
        });
    });

    $(document).on('click', '#fx-modal-copy-btn', function () {
        let link = $('#fx-modal-copy-input').val();
        document.addEventListener("copy", function (e) {
            e.clipboardData.setData("text/plain", link);
            e.preventDefault();
        }, true);
        document.execCommand("copy");
        $(this).html('<i class="fas fa-check copied"></i>');
    });

    $(document).on('click', '#modal-close', function () {
        $("#share-modal").modal('hide');
        $('#fx-share-modal-btn').empty();
    });

    $(document).on('click', '#fx-modal-send-email-btn', function () {
        let emails = $("#fx-modal-send-email-input").val();
        emails = emails.trim();
        emails = emails.split(" ");
        emails = emails.filter((email) => email);
        let link = $('#fx-modal-copy-input').val();
        let url = "<?php echo plugin_dir_url(dirname(__FILE__, 1)) . 'includes/Helpers/MailHelper.php'?>";
        $.ajax({
            url: url,
            data: {
                link: link,
                emails: emails,
            },
            type: "post",
            dataType: 'json',
            success: function (response) {
                console.log("Email sended");
            },
        })
    });

    // Spotify player

    window.onSpotifyWebPlaybackSDKReady = () => {
        var player = new Spotify.Player({
            name: 'Flexity Player',
            getOAuthToken: callback => {
                callback("<?php echo $access_token?>");
            },
            volume: 0.1
        });

        player.addListener('ready', ({device_id}) => {
            console.log('Ready with Device ID', device_id);
            const play = ({
                              spotify_uri,
                              playerInstance: {
                                  _options: {
                                      getOAuthToken,
                                      id
                                  }
                              }
                          }) => {
                getOAuthToken(access_token => {
                    fetch(`https://api.spotify.com/v1/me/player/play?device_id=${device_id}`, {
                        method: 'PUT',
                        body: JSON.stringify({uris: [spotify_uri]}),
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${access_token}`
                        },
                    });
                });
            };

            var timerId = null;
            $('.fx-player-control-icons').on("click", function () {
                let podcastUri = $(this).attr("data-uri");
                let podcastId = $(this).attr("data-id");
                let podcastDuration = $('.podcast-player-trace-' + podcastId).attr("data-seconds");

                $('.fx-latest-podcast-body-card-content-player').css("display", "none");
                $('.fx-latest-podcast-body-card').css("padding-bottom", "32px");
                $('.fx-player-plause-btns').css("display", "none");
                $('.fx-player-play-btns').css("display", "block");
                $(".fx-player-seconde-btns-play").css('display', 'none');
                $(".fx-player-seconde-btns-pause").css('display', 'block');

                $('.fx-player-main-play-' + podcastId).css('display', 'none');
                $('.fx-player-main-pause-' + podcastId).css('display', 'block');
                // $('.fx-player-start-time-'+podcastId).html('00:00');


                $(".latest-podcast-player-" + podcastId).css("display", "flex");
                $(".fx-latest-podcast-body-card-" + podcastId).css("padding-bottom", "0px");
                $('.podcast-player-trace-' + podcastId).attr("max", podcastDuration);
                play({playerInstance: player, spotify_uri: podcastUri,});
                timerId = timer(podcastId, 0, podcastDuration);
            });

            $(".podcast-player-trace").on("click", function () {
                clearInterval(timerId);
                let podcastId = $(this).attr("data-id");
                let currPos = $(this).val();
                let podcastDuration = $('.podcast-player-trace-' + podcastId).attr("data-seconds");
                player.seek(currPos * 1000).then(() => {
                    timer(podcastId, currPos, podcastDuration)
                });
            });

            function timer(podcastId, currPos, duration) {
                timerId;
                clearInterval(timerId);
                let currTime = +currPos;
                let pos = +currPos;
                timerId = setInterval(function(){
                    pos +=1;
                    currTime +=1;
                    let minutes = Math.floor(currTime / 60);
                    let seconds = currTime - minutes * 60;
                    let currFormatedTime = (minutes < 9 ? '0'+minutes : ''+minutes) +':'+ (seconds < 9 ? '0'+seconds : ''+seconds);
                    $('.fx-player-start-time-' + podcastId).text(currFormatedTime);
                    $('.podcast-player-trace-' + podcastId).val(pos);
                    if (pos == duration) {
                        clearInterval(timerId);
                        $('#fx-player-second-btn-pause-' + podcastId).css('display', 'none');
                        $('#fx-player-second-btn-play-' + podcastId).css('display', 'block');
                        $('.fx-player-main-pause-' + podcastId).css('display', 'none');
                        $('.fx-player-main-play-' + podcastId).css('display', 'block');
                        $(".fx-latest-podcast-body-card-" + podcastId).css("padding-bottom", "32px");
                        $(".latest-podcast-player-" + podcastId).css("display", "none");
                        $('.podcast-player-trace-' + podcastId).val(0);

                    }
                }, 1000);
                return timerId;
            }

            $(".player-volume-range-jq").on("click", setVolume).on("mouseup", setVolume).on("input", setVolume);

            function setVolume() {
                let volume = $(this).val();
                player.setVolume(volume).then(() => {
                })
            }

            $(".opened-player-control-btns").on("click", function () {
                let id = $(this).attr("data-id");
                player.togglePlay().then(() => {
                    let podcastId = $(this).attr("data-id");
                    $('.fx-player-seconde-btns-' + podcastId).toggle();
                    $('.fx-player-main-btns-' + podcastId).toggle();
                    let currPos = $('.podcast-player-trace-' + podcastId).val();
                    let podcastDuration = $('.podcast-player-trace-' + podcastId).attr("data-seconds");
                    if (timerId) {
                        clearInterval(timerId);
                        timerId = null;
                    } else {
                        timer(podcastId, currPos, podcastDuration);
                    }
                });
            });

            $('.player-btns-forward').on('click', function () {
                let nextPodcastNumber = $(this).attr('data-next');
                $('#fx-player-next-' + nextPodcastNumber).click();
            });
            $('.player-btns-backward').on('click', function () {
                let prevPodcastNumber = $(this).attr('data-prev');
                $('#fx-player-next-' + prevPodcastNumber).click();
            });

        });
        player.connect();
    };

</script>