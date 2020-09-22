<?php

namespace App\Attachment;

use App\Model\Post;

class PostAttachment
{
    public static function upload (Post $post) {
        $image = $post->getImage();
        if (empty($image)) {
            return;
        }
        $directory = UPLOAD_PATH . DIRECTORY_SEPARATOR . 'posts';
        if (file_exists($directory) === false) {
            mkdir($directory, 0777, true);
        }
        
        $filename = uniqid("", true) . '.jpg';
        move_uploaded_file($image, $directory . DIRECTORY_SEPARATOR . $filename);
        $post->setImage($filename);
    }
}