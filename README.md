# Realtime Chat Widget using Pusher

The first version of this sample shows how to create a Realtime Chat Widget with a PHP backend. Later versions will demonstrate how to achieve this using other backend technologies.

## Demo

You can see a live version of the chat widget in action here:
http://pusher-realtime-chat-widget.phpfogapp.com/src/

## Tutorial

A tutorial of how to get up and running with the widget an be found here:
http://pusher.com/tutorials/realtime_chat_widget

## src

### /php

The server code required to use the widget with a PHP back-end. The `src/chat.html` file is set up to us the PHP back-end.

### /ruby-sinatra

The server code required to run the example under [Sinatra](http://www.sinatrarb.com/).

The `src/chat.html` file will need to be updated so that the `PusherChatWidget` talks to the sinatra app. This means providing a `chatEndPoint` setting to point to `/chat` as follows:

    var pusher = new Pusher('49e26cb8e9dde3dfc009')
    var chatWidget = new PusherChatWidget(pusher, {
      appendTo: '#pusher_chat_widget',
      chatEndPoint: '/chat'
    });
    
You can then get started by:

    cd src/ruby-sinatra
    bundle install
    bundle exec ruby -rubygems chat.rb
    
And navigating to http://localhost:4567/ to see the side-by-side example or http://localhost:4567/chat.html to see the standalone example.