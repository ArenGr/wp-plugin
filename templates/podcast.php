<?php
get_header();
use \Config\Config;
global $wpdb;

$post_id = get_the_id();
$table_podcasts = Config::TABLE_WP_FX_PODCASTS;
$table_tokens = Config::TABLE_WP_FX_TOKENS;
$table_posts = 'wp_posts';
$podcast = $wpdb->get_results("SELECT * FROM `$table_podcasts` WHERE post_id = $post_id");

$image = get_field('overview_image', $post_id);
$image = $image ?  $image=esc_url($image['url']) : plugin_dir_url(dirname(__FILE__, 1)).Config::FX_PODCAST_IMAGES_DIR_MEDIUM. $podcast[0]->album_image;

$release_date = date("j F, Y", strtotime($podcast[0]->track_release_date));

$related_posts = $wpdb->get_results("SELECT pd.track_name, pd.artist_name, pd.album_image, ps.guid, pd.track_release_date, pd.track_duration_ms FROM `$table_podcasts` as pd LEFT JOIN `$table_posts` as ps ON pd.post_id = ps.id WHERE pd.post_id <> '$post_id'  ORDER BY `created_at` DESC LIMIT 10");

$tokens = $wpdb->get_results("SELECT access_token FROM `$table_tokens` LIMIT 1");
$access_token = $tokens[0]->access_token;
?>
<div class="fx-single-podcast">
    <div class="container-fluid fx-single-podcast-heading">
        <div class="row">
            <div class="row col-sm-4 text-center fx-single-podcast-heading-image">
                <div class="col-sm-3"></div>
                <div class="col-sm-9">
                    <img class="mx-auto d-block" src="<?php echo $image ?>" alt="Podcast image">
                </div>
            </div>
            <div class="col-sm-8 fx-single-podcast-heading-text-block">
                <div class="col-sm-12 align-self-center fx-single-podcast-heading-title"><?php echo $podcast[0]->track_name ?></div>
                <div class="col-sm-12 align-self-center fx-single-podcast-heading-author-block">
                    <div class="col-sm-12 d-flex vertical-align-center fx-single-podcast-heading-author">
                        <span><?php echo $podcast[0]->artist_name ?></span>
                        <span class="align-self-center fx-single-podcast-heading-dot">
                            <i class="fas fa-circle"></i>
                        </span>
                        <span class="fx-single-podcast-heading-date">
                            Last updated: <?php echo $release_date ?>
                        </span>
                    </div>
                </div>
                <div class="fx-single-podcast-heading-description">
                    The long barrow was built on land previously
                    inhabited in the Mesolithic period. It consisted of
                    a sub-rectangular earthen tumulus, estimated to have
                    been 15 metres (50 feet) in length, with a chamber built
                    from sarsen megaliths on its eastern end. Both inhumed
                    and cremated human remains were placed within this
                    chamber during the Neolithic period, representing at
                    least nine or ten individuals.
                </div>

                <div class="row col-sm-12 fx-single-podcast-heading-buttons">
                    <div class="col-sm-6">
                        <button class="fx-single-podcast-main-play-pause-btn" data-uri="<?php echo $podcast[0]->track_uri ?>">
                            <span class="fx-single-podcast-main-play-pause-btn-icons">
                                <i class="fa fa-play fa-xs" aria-hidden="true"></i>
                            </span>
                            <span class="fx-single-podcast-main-play-pause-btn-icons fx-single-podcast-main-play-pause-btn-icons-pause">
                                <i class="fa fa-pause fa-xs" aria-hidden="true"></i>
                            </span>
                            <span class="fx-single-podcast-main-play-pause-btn-text">
                                Play All
                            </span>
                        </button>
                        <button class="fx-single-podcast-main-share-btn fx-podcast-heading-btn fx-podcast-heading-share" id="fx-single-podcast-main-share-btn">
                            <span class="fx-single-podcast-main-share-btn-icon"><i class="fa fa-share-alt fa-xs" aria-hidden="true"></i></span>
                            <span class="fx-single-podcast-main-share-btn-text">Share</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fx-single-podcast-body">
    <!--Podcast Share Modal-->
         <div id="fx-single-podcast-share-modal-wrapper"></div>
        <!--Podcast Player-->
        <div class="fx-single-podcast-player-wrapper" id="fx-podcast-player">
            <div class="container fx-single-podcast-player">
                <div class="row">
                    <div class="col-sm-2 d-flex align-items-center player-btns">
                        <span class="col-sm-4 player-btns-backward">
                            <i class="fas fa-step-backward fa-xs" aria-hidden="true"></i>
                        </span>
                        <span class="col-sm-4 opened-player-control-btns fx-single-podcast-player-control-btns">
                            <i class="fa fa-pause fa-xs fx-player-seconde-btns-pause fx-podcast-single-player-seconde-icons" aria-hidden="true"></i>
                            <i class="fa fa-play fa-xs fx-player-seconde-btns-play fx-podcast-single-player-seconde-icons" aria-hidden="true" ></i>
                        </span>
                        <span class="col-sm-4 fa-xs player-btns-forward">
                            <i class="fas fa-step-forward" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="col-sm-10 d-flex align-items-center player-range-wrapper">
                    <span class="col-sm-1 text-center player-range-start-time fx-single-podcast-player-start-time">
                        00:00
                    </span>
                        <span class="col-sm-8 d-flex align-items-center">
                        <input type="range" min="0" max="0" value="0" step="1" class="podcast-player-trace player-trace fx-single-podcast-player-trace" data-seconds="<?php echo \Inc\Helpers\DateHelper::convertTrackMsDurationToSecond($podcast[0]->track_duration_ms)?>">
                    </span>
                        <span class="col-sm-1 text-center player-range-end-time">
                        <?php echo \Inc\Helpers\DateHelper::convertTrackMsDurationToMinute($podcast[0]->track_duration_ms) ?>
                    </span>
                        <span class="col-sm-2 d-flex align-items-center player-volume-wrapper">
                        <span class="col-sm-2  player-volume-icon">
                            <i class="fas fa-volume-up"></i>
                        </span>
                        <span class="col-sm-10 d-flex align-items-center">
                            <input type="range" min="0" max="1" value="0" step="0.001" class="player-volume-range-style fx-single-podcast-player-volume-trace">
                        </span>
                    </span>
                    </div>
                </div>
            </div>
        </div>
        <!--Podcasts Pmaylist-->
<!--        <div class="container fx-single-podcast-pmaylist-wrapper">-->
<!--            <div class="row fx-single-podcast-pmaylist-head">-->
<!--                <div class="row col-sm-12">-->
<!--                    <div class="col-sm-1">-->
<!--                        <div>#</div>-->
<!--                    </div>-->
<!--                    <div class="row col-sm-6">-->
<!--                        <div class="col-sm-10">TITLE</div>-->
<!--                        <div class="col-sm-2"></div>-->
<!--                    </div>-->
<!--                    <div class="row col-sm-2">-->
<!--                        <div class="col-sm-2"></div>-->
<!--                        <div class="col-sm-10">DURATION</div>-->
<!--                    </div>-->
<!--                    <div class="row col-sm-2">-->
<!--                        <div class="col-sm-2"></div>-->
<!--                        <div class="col-sm-10">DATE</div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="row fx-single-podcast-pmaylist-separator">-->
<!--                <div class="col-12 fx-single-podcast-pmaylist-line"></div>-->
<!--            </div>-->
<!--            --><?php //foreach ($related_posts as $key => $related_post) {?>
<!--                <div class="row fx-single-podcast-pmaylist-body">-->
<!--                    <div class="row col-sm-12 fx-single-podcast-pmaylist-body-content">-->
<!--                        <div class="col-sm-1">-->
<!--                            <div>--><?php //echo $key + 1?><!--</div>-->
<!--                        </div>-->
<!--                        <div class="row col-sm-6">-->
<!--                            <div class="col-sm-10">--><?php //echo $related_post->track_name ?><!--</div>-->
<!--                            <div class="col-sm-2"></div>-->
<!--                        </div>-->
<!--                        <div class="row col-sm-2">-->
<!--                            <div class="col-sm-2"></div>-->
<!--                            <div class="col-sm-10">--><?php //echo \Inc\Helpers\DateHelper::convertTrackMsDurationToMinute($related_post->track_duration_ms) ?><!--</div>-->
<!--                        </div>-->
<!--                        <div class="row col-sm-2">-->
<!--                            <div class="col-sm-2"></div>-->
<!--                            <div class="col-sm-10">--><?php //$formated_date = \Inc\Helpers\DateHelper::getYear($related_post->track_release_date); echo $formated_date['full_date']?><!--</div>-->
<!--                        </div>-->
<!--                        <div class="row col-sm-1">-->
<!--                            <div class="col-sm-10"></div>-->
<!--                            <div class="col-sm-2">-->
<!--                                <i class="fa fa-share-alt fa-xs" aria-hidden="true"></i>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            --><?php //}?>
<!--        </div>-->
        <!--Related Podcasts-->
        <div class="container fx-podcast-related-posts">
            <div class="container-fluid">
                <div class="container fx-podcast-related-posts-header">
                    <div class="fx-podcast-related-posts-header-text">
                        YOU MIGHT ALSO LIKE
                    </div>
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="list-inline owl-carousel owl-theme owl-loaded owl-drag"
                             id="fx-podcast-related-posts-owl-carousel">
                            <?php foreach ($related_posts as $related_post) { ?>
                                <div class="container">
                                    <a href="<?php echo $related_post->guid ?>">
                                        <div class="fx-podcast-related-post-wrapper">
                                            <div class="fx-podcast-related-post-image">
                                                <img width="176" height="176"
                                                     src="<?php echo plugin_dir_url(dirname(__FILE__, 1)).Config::FX_PODCAST_IMAGES_DIR_MEDIUM.$related_post->album_image ?>"
                                                     class="img-responsive wp-post-image" alt=""
                                                     srcset=""
                                                     sizes="">
                                            </div>
                                            <div class="fx-podcast-related-post-title">
                                                <?php echo $related_post->track_name ?>
                                            </div>
                                            <div class="fx-podcast-related-post-author">
                                                <?php echo $related_post->artist_name ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>
<script src="https://sdk.scdn.co/spotify-player.js"></script>
<script type="text/javascript">
    /* Owl Carousle */
    (function (jQuery) {
        "use strict";
        jQuery(document).ready(function () {
            jQuery('#fx-podcast-related-posts-owl-carousel').owlCarousel({
                width: 900,
                heigth: 176,
                margin: 32,
                loop: true,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
                nav: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    }
                }
            });
            $('#fx-podcast-related-posts-owl-carousel').css('visibility', 'visible');

        });
    })(jQuery);


    /* Share Modal */

    $('#fx-single-podcast-main-share-btn').on('click', function () {
        let link = window.location.href;
        let url = "<?php echo plugin_dir_url(dirname(__FILE__, 1)) . 'templates/modal.php'?>";
        $.ajax({
            url: url,
            type: 'GET',
            success: function (modal) {
                // console.log(modal);debugger;
                $('#fx-single-podcast-share-modal-wrapper').html(modal);
                $('#fx-single-podcast-share-modal-wrapper').css('display', 'block');
                $('#share-modal').modal('show');
                $('#fx-modal-copy-input').val(link);
            }
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

    $(document).on('click', '#modal-close', function () {
        $("#share-modal").modal('hide');
        $('#fx-single-podcast-share-modal-wrapper').empty();
        $('#fx-single-podcast-share-modal-wrapper').css('display', 'none');
    });


    /* Spotify Tracker */

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
            $('.fx-single-podcast-main-play-pause-btn').on("click", function () {
                let podcastUri = $(this).attr("data-uri");
                let podcastDuration = $('.fx-single-podcast-player-trace').attr('data-seconds');

                $('.fx-single-podcast-player-trace').attr("max", podcastDuration);
                $('.fx-single-podcast-player-main-icons').toggle();
                $('.fx-podcast-single-player-seconde-icons').toggle();
                $('.fx-single-podcast-main-play-pause-btn-icons').toggle();
                $('.fx-single-podcast-player-wrapper').css("display", "flex");
                play({
                    playerInstance: player,
                    spotify_uri: podcastUri,
                });
                timer(0, podcastDuration);
            });

            $(".fx-single-podcast-player-trace").on("click", function() {
                clearInterval(timerId);
                let currPos = $(this).val();
                let podcastDuration = $(this).attr("data-seconds");
                player.seek(currPos * 1000).then(() => {
                    timer(currPos, podcastDuration)
                });
            });

            function timer(currPos, duration) {
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
                    $('.fx-single-podcast-player-start-time').text(currFormatedTime);
                    $('.fx-single-podcast-player-trace').val(pos);

                    if (pos == duration) {
                        clearInterval(timerId);
                        $('.fx-single-podcast-main-play-pause-btn-icons').toggle();
                        $('.fx-podcast-single-player-seconde-icons').toggle();
                        $('.fx-single-podcast-player-wrapper').css("display", "none");
                        $('.fx-single-podcast-player-trace').val(0);
                    }
                }, 1000);
                return timerId;
            }

            $('.fx-single-podcast-player-volume-trace').on('click', setVolume).on('mouseup', setVolume).on('input', setVolume);
            function setVolume() {
                let volume = $(this).val();
                player.setVolume(volume).then(() => {})
            }

            $(".fx-single-podcast-player-control-btns").on("click", function () {
                player.togglePlay().then(() => {
                    $('.fx-single-podcast-main-play-pause-btn-icons').toggle();
                    $('.fx-podcast-single-player-seconde-icons').toggle();
                    let currPos = $('.fx-single-podcast-player-trace').val();
                    let podcastDuration = $('.fx-single-podcast-player-trace').attr("data-seconds");
                    if (timerId){
                        clearInterval(timerId);
                        timerId = null;
                    }else{
                        timer(currPos, podcastDuration);
                    }
                });
            });
        });
        player.connect();
    };
</script>
