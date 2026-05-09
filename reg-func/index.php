<?php

$value = "picture.jpg";

function getExtension($value)
{
    if (preg_match('/\.([^\.]+)$/', $value, $matches)) {
        echo $matches[1];
    }
}

getExtension($value);

$value = "example.png";

function getName($value)
{
    $archives = ["zip", "rar", "7z", "tar", "gz"];
    $audio = ["mp3", "wav", "flac"];
    $video = ["mp4", "avi", "mpg"];
    $picture = ["jpg", "png", "jpeg"];
    if (preg_match('/\.([^\.]+)$/', $value, $matches)) {
        if (in_array($matches[1], $archives)) {
            echo "This is an archive";
        } elseif (in_array($matches[1], $audio)) {
            echo "This is an audio file";
        } elseif (in_array($matches[1], $video)) {
            echo "This is a video file";
        } elseif (in_array($matches[1], $picture)) {
            echo "This is a picture";
        } else {
            echo "I do not know what is it!";
        }
    }
}

getName($value);

$value = '<title class="name">Example</title><div>Content</div>';

function findInTitle($value)
{
    if (preg_match("/<title\b[^>]*>(.*?)<\/title>/", $value, $matches)) {
        echo $matches[1];
    }
}

findInTitle($value);

$value = '<a href="page1">Link1</a>
         <a href="page2.ikkk" target="_blank">Link2</a>
         <a href=\'page3\'>Link3</a>
         <a href="html.page4.ttt///kk">Link4</a>
         <a class="btn" href="page5">Link5</a>
         <h>Title</h>';

function findAllLinksInHref($value)
{
    if (
        preg_match_all('/<a\s+[^>]*href=["\']([^"\']*)["\']/', $value, $matches)
    ) {
        print_r($matches[1]);
    }
}

findAllLinksInHref($value);

$value = '<img src="image.jpg">
           <img src="photo.png" alt="Photo">
           <img class="icon" src="icon.svg" width="20">
           <img src=\'avatar.gif\'>
           <h>Title</h>';

function findAllLinksInSrc($value)
{
    if (
        preg_match_all(
            '/<img\s+[^>]*src=["\']([^"\']*)["\']/',
            $value,
            $matches,
        )
    ) {
        print_r($matches[1]);
    }
}

findAllLinksInSrc($value);

$value = 'And so he spoke
        And so he spoke
        That Lord of Castamere
        But now the rains weep over his hall
        And not a soul to hear ';

$sub_str = "Lord of Castamere";

function doStrong($value, $sub_str)
{
    $pattern = "/" . preg_quote($sub_str, "/") . "/";
    $replace = "<strong>" . $sub_str . "</strong>";
    $res = preg_replace($pattern, $replace, $value);
    echo $res;
}

doStrong($value, $sub_str);

$value = "Hi! :) How are you? ;) i am upset :(";

function replaceEmodji($value)
{
    $pattern = ["/:\)/", "/;\)/", "/:\(/"];
    $replace = [
        '<img src="smile.png" alt="😊">',
        '<img src="wink.png" alt="😉">',
        '<img src="sad.png" alt="😭">',
    ];
    $res = preg_replace($pattern, $replace, $value);
    echo $res;
}

replaceEmodji($value);

$value = "I am  very       happy today";

function removeExtraSpaces($value)
{
    $pattern = "/\s+/";
    $replace = " ";
    $res = preg_replace($pattern, $replace, $value);
    echo $res;
}

removeExtraSpaces($value);
