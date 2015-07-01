<?php

namespace Success\CategoryBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Success\CategoryBundle\CategoryBundle;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CategoryExtension extends Extension {

  /**
   * {@inheritDoc}
   */
  public function load(array $configs, ContainerBuilder $container) {
    $configuration = new Configuration();
    $config = $this->processConfiguration($configuration, $configs);

    $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.yml');
    
    $this->loadDriver('doctrine/orm', $config, $loader);
    
    /*$driver = $config['driver'];
    
    $this->loadDriver($driver, $config, $loader);

    $container->setParameter('category.driver', $driver);
    $container->setParameter('category.driver.' . $driver, true);

    $classes = $config['classes'];

    $this->mapClassParameters($classes, $container);    */
  }

  protected function loadDriver($driver, array $config, YamlFileLoader $loader) {
    if (!in_array($driver, CategoryBundle::getSupportedDrivers())) {
      throw new \InvalidArgumentException(sprintf('Driver "%s" is unsupported by CategoryBundle.', $driver));
    }

    $loader->load(sprintf('container/driver/%s.yml', $driver));

    //$loader->load('container/category.yml');
  }

  /**
   * Remap class parameters.
   *
   * @param array            $classes
   * @param ContainerBuilder $container
   */
  protected function mapClassParameters(array $classes, ContainerBuilder $container) {
    foreach ($classes as $model => $serviceClasses) {
      foreach ($serviceClasses as $service => $class) {
        $service = $service === 'form' ? 'form.type' : $service;
        $container->setParameter(sprintf('success.%s.%s.class', $service, $model), $class);
      }
    }
  }

}
