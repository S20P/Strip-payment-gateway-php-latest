<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcaa6b07ed8cea4ae712e621d2bfaf856
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitcaa6b07ed8cea4ae712e621d2bfaf856::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitcaa6b07ed8cea4ae712e621d2bfaf856::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
