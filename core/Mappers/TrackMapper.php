<?php

namespace CarregMusic\Mappers;

use CarregMusic\Models\Track;

class TrackMapper
{
    public static function Map($record)
    {
        $track = new Track();
        $track->id = $record['trackID'];
        $track->title = $record['trackTitle'];
        $track->artists = $record['artists'];
        $track->artistCount = $record['artistCount'];
        $track->coverPicture = $record['coverPicture'];

        return $track;
    }
}