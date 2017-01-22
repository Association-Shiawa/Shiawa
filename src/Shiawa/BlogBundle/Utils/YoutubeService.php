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

    public function getLastVideos($maxResults = 1)
    {
        $videos = $this->youtube->playlistItems->listPlaylistItems('contentDetails', array('playlistId' => $this->uploadsID, 'maxResults' => $maxResults));
        return $videos;
    }

    public function getAMVs(){
        $playlistId = "PLITDrG6K2FHf8HoECBnJmOyrlPSnMA_FN";
        $videos = $this->youtube->playlistItems->listPlaylistItems('contentDetails', array('playlistId' => $playlistId));
        return $videos;
    }

    public function getCMVs(){
        $playlistId = "PLITDrG6K2FHdyPJYL9K97090uP5TX7ObI";
        $videos = $this->youtube->playlistItems->listPlaylistItems('contentDetails', array('playlistId' => $playlistId));
        return $videos;
    }

    public function getInterviews(){
        $playlistId = "PLITDrG6K2FHeI4hT8FKEcJWcs2ezaA001";
        $videos = $this->youtube->playlistItems->listPlaylistItems('contentDetails', array('playlistId' => $playlistId));
        return $videos;
    }

    public function getChannelInfos()
    {
       return $channelInfos = $this->youtube->channels->listChannels("snippet, contentDetails", array('id' => $this->channelID));
    }
}