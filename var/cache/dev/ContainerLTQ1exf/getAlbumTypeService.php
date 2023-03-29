<?php

namespace ContainerLTQ1exf;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getAlbumTypeService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Form\AlbumType' shared autowired service.
     *
     * @return \App\Form\AlbumType
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/form/FormTypeInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/form/AbstractType.php';
        include_once \dirname(__DIR__, 4).'/src/Form/AlbumType.php';

        return $container->privates['App\\Form\\AlbumType'] = new \App\Form\AlbumType();
    }
}
