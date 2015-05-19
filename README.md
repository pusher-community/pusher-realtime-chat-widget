# Realtime Chat Widget using Pusher

This sample shows how to create a Realtime Chat Widget with a PHP, Ruby or Node.js backend.

## Demo

Here is a [live version of the chat widget in action](http://pusher.com/tutorials/realtime_chat_widget).

## Tutorial

We've put together a [tutorial on how to get up and running with the widget](http://pusher.com/tutorials/realtime_chat_widget).

## src

### /nodejs

The server code required to run the example using [Node.js](http://nodejs.org/).

The `src/chat.html` file will need to be updated so that the `PusherChatWidget` talks to the Node app. This means providing a `chatEndPoint` setting to point to `/chat` as follows:

    var pusher = new Pusher("CHANGE_KEY")
    var chatWidget = new PusherChatWidget(pusher, {
      appendTo: "#pusher_chat_widget",
      chatEndPoint: "/chat"
    });
    
You can then get started by:

    cd src/nodejs
    npm install
    node app.js
    
And navigating to http://localhost:4567 to see the side-by-side example or http://localhost:4567/chat.html to see the standalone example.

### /php

The server code required to use the widget with a PHP back-end. Update the `src/chat.html` file to your `PUSHER_APP_KEY`:


```
var pusher = new Pusher("CHANGE_KEY")
```

Then, set up the PHP back-end:

```
cd src/php
composer install
cd ..
PHP -s localhost:8080
```

And navigating to http://localhost:8080/ to see the side-by-side example or http://localhost:8080/chat.html to see the standalone example. 

### /ruby-sinatra

The server code required to run the example using [Sinatra](http://www.sinatrarb.com/).

The `src/chat.html` file will need to be updated so that the `PusherChatWidget` talks to the sinatra app. This means providing a `chatEndPoint` setting to point to `/chat` as follows:

    var pusher = new Pusher("CHANGE_KEY")
    var chatWidget = new PusherChatWidget(pusher, {
      appendTo: "#pusher_chat_widget",
      chatEndPoint: "/chat"
    });
    
You can then get started by:

    cd src/ruby-sinatra
    bundle install
    bundle exec ruby -rubygems chat.rb
    
And navigating to http://localhost:4567/ to see the side-by-side example or http://localhost:4567/chat.html to see the standalone example.
