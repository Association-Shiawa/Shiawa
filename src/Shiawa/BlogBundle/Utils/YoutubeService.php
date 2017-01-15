<?php

namespace Shiawa\BlogBundle\Utils;

class YoutubeService {

    private $apiKey = null;
    private $client;
    private $youtube;
    private $channelID;

    public function __construct($apiKey, $channelID)
    {
        $this->apiKey = $apiKey;
        $this->client = new \Google_Client();
        $this->client->setDeveloperKey($this->apiKey);
        $this->youtube = new \Google_Service_YouTube($this->client);
        $this->channelID = $channelID;
    }

    public function getLastVideos()
    {
        $channelInfos = $this->youtube->channels->listChannels("snippet, contentDetails", array('id' => $this->channelID));
        die($channelInfos);
//        $videos =
        return $videos;
    }

    public function getAMVs(){

    }

    public function getCMVs(){

    }

    public function getInterviews(){

    }
}