<?php

namespace Shiawa\BlogBundle\Utils;

class YoutubeService {

    private $apiKey;
    private $client;
    private $youtube;
    private $channelID;
    //PlaylistID for uploaded videos
    private $uploadsID;

    public function __construct($apiKey, $channelID, $uploadsID)
    {
        $this->apiKey = $apiKey;
        $this->client = new \Google_Client();
        $this->client->setDeveloperKey($this->apiKey);
        $this->youtube = new \Google_Service_YouTube($this->client);
        $this->channelID = $channelID;
        $this->uploadsID = $uploadsID;
    }

    public function getLastVideos()
    {
        $videos = $this->youtube->playlistItems->listPlaylistItems('contentDetails', array('playlistId' => $this->uploadsID));
        //channels->listChannels("snippet, contentDetails", array('id' => $this->channelID));
        var_dump($videos['items'][0]['videoId']);die();
        return $videos;
    }

    public function getAMVs(){

    }

    public function getCMVs(){

    }

    public function getInterviews(){

    }
}