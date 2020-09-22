<?php

namespace App\Attachment;

use App\Model\Post;
use Intervention\Image\ImageManager;

class PostAttachment
{
    public static function upload (Post $post) {
        $image = $post->getImage();
        if (empty($image) || $post->shouldUpload() === false) {
            return;
        }
        $directory = UPLOAD_PATH . DIRECTORY_SEPARATOR . 'posts';
        if (file_exists($directory) === false) {
            mkdir($directory, 0777, true);
        }
        if (!empty($post->getOldImage())) {
            $formats = ['small', 'large'];
            foreach ($formats as $format) {
                $oldFile = $directory . DIRECTORY_SEPARATOR . $post->getOldImage() . '_' . ;
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }
        }
        $filename = uniqid("", true);
        $manager = new ImageManager(['driver' => 'gd']);
        $manager
            ->make($image)
            ->fit(350, 200)
            ->save($directory . DIRECTORY_SEPARATOR . $filename . '_small.jpg');
        $manager
            ->make($image)
            ->fit(1280)
            ->save($directory . DIRECTORY_SEPARATOR . $filename . '_large.jpg');
        $post->setImage($filename);
    }
}