<?php

use Shouty\Shouty;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Behat\Context\Initializer\ContextInitializer;
use Behat\Behat\Context\Context;

class ShoutyHelper
{
    public function getShouty()
    {
        if (!isset($this->shouty))
            $this->shouty = new Shouty();
        return $this->shouty;
    }

    public function reset()
    {
        unset($this->shouty);
    }
}

class ShoutyInitializer implements ContextInitializer
{
    private $shoutyHelper;

    public function __construct()
    {
        $this->shoutyHelper = new ShoutyHelper();
    }

    public function supportsContext(Context $context)
    {
        return true;
    }

    public function initializeContext(Context $context)
    {
        $context->setShoutyHelper($this->shoutyHelper);
    }
}

class ShoutyExtension implements Extension
{
    public function getConfigKey()
    {
        return 'shouty_initializer';
    }
    public function load(ContainerBuilder $container, array $config)
    {
        $definition = $container->register('shouty_initializer', 'ShoutyInitializer');
        $definition->addTag(ContextExtension::INITIALIZER_TAG);
    }
    public function configure(ArrayNodeDefinition $builder) {}
    public function initialize(ExtensionManager $extensionManager) {}
    public function process(ContainerBuilder $container) {}
}
return new ShoutyExtension;
