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
        move_uploaded_file($image, UPLOAD_PATH . DIRECTORY_SEPARATOR . 'demo.jpg');
    }
}