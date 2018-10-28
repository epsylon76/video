<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit138e48832fed2208d7c03baa4236faed
{
    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'ZipStream\\' => 10,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ZipStream\\' => 
        array (
            0 => __DIR__ . '/..' . '/maennchen/zipstream-php/src',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit138e48832fed2208d7c03baa4236faed::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit138e48832fed2208d7c03baa4236faed::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
