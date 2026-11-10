<?php

if (!function_exists('uploadImage')) {

    function uploadImage($file, $folder)
    {
        if (!$file || !$file->isValid()) {

            return null;
        }

        $uploadPath =
            FCPATH .
            'uploads/' .
            $folder;

        if (!is_dir($uploadPath)) {

            mkdir(
                $uploadPath,
                0777,
                true
            );
        }

        $namaFile =
            uniqid() . '.jpg';

        $fullPath =
            $uploadPath .
            '/' .
            $namaFile;

        $image =
            \Config\Services::image();

        $image
            ->withFile($file)

            ->resize(
                1280,
                1280,
                true,
                'height'
            )

            ->save(
                $fullPath,
                60
            );

        return $namaFile;
    }
}
