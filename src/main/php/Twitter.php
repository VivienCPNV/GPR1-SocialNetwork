<?php

namespace SocialNetwork;

use RuntimeException;

require_once 'Follower.php';
require 'IObservable.php';

class Twitter implements IObservable
{
    private $observers = array();
    private $twits = array();
    public function __construct(array $observers = array())
    {
        foreach($observers as $observer){
            if(in_array($observer, $this->observers, TRUE)){
                throw new SubscriberAlreadyExistsException();
            }
            array_push($this->observers, $observer);
        }
    }

    public function subscribe(array $observers):void
    {
        //Array merge not workey
        foreach($observers as $observer){
            if (in_array($observer, $this->observers, TRUE)){
                throw new SubscriberAlreadyExistsException();
            }
            array_push($this->observers, $observer);
        }
    }

    public function unsubscribe(IObserver $observer):void
    {
        if (empty($this->observers)){
            throw new EmptyListOfSubscribersException();
        }
        if (($key = array_search($observer, $this->observers, TRUE)) !== FALSE){
            unset($this->observers[$key]);
        } else {
            throw new SubscriberNotFoundException();
        }
    }

    public function notifyObservers():void
    {
        if (empty($this->observers)){
            throw new EmptyListOfSubscribersException();
        }
        //Todo notify
    }

    public function getObservers():array
    {
        return $this->observers;
    }

    public function getTwits():array
    {
        return $this->twits;
    }
}

class TwitterException extends RuntimeException { }
class EmptyListOfSubscribersException extends TwitterException { }
class SubscriberAlreadyExistsException extends TwitterException { }
class SubscriberNotFoundException extends TwitterException { }