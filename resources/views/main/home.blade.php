@extends('master')

@section('content')
    <?php
    $first_feed = $feed[0];
    unset($feed[0]);
    ?>

    <div class="news-feed">
        <div class="row">
            <div class="col-xs-12">
                <h2><a href="#"><?php echo $first_feed['title'] ?></a></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="#" class="feed-link">
                    <span class="feed-thumbnail-lg"
                          style="background-image: url(<?php echo $first_feed['img']; ?>);"></span>
                    <span class="feed-link-text">
                        <?php echo $first_feed['content']; ?>
                    </span>
                </a>
            </div>
        </div>

        <?php
        for($i = 1; $i < sizeof($feed); $i++):
            if(isset($feed[$i])):
        ?>
                <div class="vertical-spacing"></div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <h4><a href="#"><?php echo $feed[$i]['title']; ?></a></h4>
                        <a href="#" class="feed-link">
                                        <span class="feed-thumbnail"
                                              style="background-image: url(<?php echo $feed[$i]['img']; ?>);">
                                        </span>
                                        <span class="feed-link-text">
                                            <?php echo $feed[$i]['content']; ?>
                                        </span>
                        </a>
                    </div>
                    <?php
                    if(isset($feed[$i + 1])):
                    ?>
                        <div class="col-md-6 col-sm-12">
                            <h4><a href="#"><?php echo $feed[$i + 1]['title']; ?></a></h4>
                            <a href="#" class="feed-link">
                                            <span class="feed-thumbnail"
                                                  style="background-image: url(<?php echo $feed[$i + 1]['img']; ?>);">
                                            </span>
                                            <span class="feed-link-text">
                                                <?php echo $feed[$i + 1]['content']; ?>
                                            </span>
                            </a>
                        </div>
            <?php
                    endif;
            ?>
        </div>
        <?php
            endif;
        endfor;
        ?>
    </div>
@endsection