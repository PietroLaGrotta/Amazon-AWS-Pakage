<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<?php

    //die('This is just an example and will not work without proper store credentials.');   

    /*
     * This script retrieves a list of active feeds for the store "myStore" and display info on them.
     */

    use AmazonMWS\AmazonConfiguration as Config;
    use AmazonMWS\Feeds\AmazonFeedList;

    Config::$merchantId = 'bla bla bla';
    Config::$marketplaceId = 'bla bla bla';
    Config::$keyId = 'bla bla bla';
    Config::$secretKey = 'bla bla bla';
    Config::$serviceUrl = 'bla bla bla';
    Config::$MWSAuthToken = 'bla bla bla';
    
    $list = getAmazonFeedStatus();
    
    var_dump($list); die();
    
    if ($list) {
        
        echo 'Feed Status Report<hr>';
        
        foreach ($list as $feed) {
            //these are arrays
            echo '<b>Feed ID:</b> '.$feed['FeedSubmissionId'];
            echo '<br><b>Type:</b> '.$feed['FeedType'];
            echo '<br><b>Date Sent:</b> '.$feed['SubmittedDate'];
            echo '<br><b>Status:</b> '.$feed['FeedProcessingStatus'];
            echo '<br><br>';
        }
    }

    /**
     * This function will retrieve a list of all items with quantity that was adjusted within the past 24 hours.
     * The entire list of items is returned, with each item contained in an array.
     * Note that this does not relay whether or not the feed had any errors.
     * To get this information, the feed's results must be retrieved.
     */
    function getAmazonFeedStatus(){
        //require('../includes/classes.php'); //autoload classes, not needed if composer is being used
        try {
            
            $amz=new AmazonFeedList( Config::$configurationKey );
            $amz->setTimeLimits('- 24 hours'); //limit time frame for feeds to any updated since the given time
            $amz->setFeedStatuses(array("_SUBMITTED_", "_IN_PROGRESS_", "_DONE_")); //exclude cancelled feeds
            $amz->fetchFeedSubmissions(); //this is what actually sends the request
            
            return $amz->getFeedList();
            
        } catch (Exception $ex) {
            echo 'There was a problem with the Amazon library. Error: '.$ex->getMessage();
        }
    }

    /**
     * This function will send a provided Inventory feed to Amazon.
     * Amazon's response to the feed is returned as an array.
     * This function is not actively used on this example page as a safety precaution.
     */
//    function sendInventoryFeed($feed) {
//        try {
//            $amz=new AmazonFeed(); //if there is only one store in config, it can be omitted
//            $amz->setFeedType("_POST_INVENTORY_AVAILABILITY_DATA_"); //feed types listed in documentation
//            $amz->setFeedContent($feed); //can be either XML or CSV data; a file upload method is available as well
//            $amz->submitFeed(); //this is what actually sends the request
//            return $amz->getResponse();
//        } catch (Exception $ex) {
//            echo 'There was a problem with the Amazon library. Error: '.$ex->getMessage();
//        }
//    }

    /**
     * This function will get the processing results of a feed previously sent to Amazon and give the data.
     * In order to do this, a feed ID is required. The response is in XML.
     */
//    function getFeedResult($feedId) {
//        try {
//            $amz=new AmazonFeedResult("myStore", $feedId); //feed ID can be quickly set by passing it to the constructor
//            $amz->setFeedId($feedId); //otherwise, it must be set this way
//            $amz->fetchFeedResult();
//            return $amz->getRawFeed();
//        } catch (Exception $ex) {
//            echo 'There was a problem with the Amazon library. Error: '.$ex->getMessage();
//        }
//    }


?>

    </body>
</html>
