<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new Settings\ConfigBundle\SettingsConfigBundle(),
            new Venture\VendorBundle\VentureVendorBundle(),
            new Venture\RawMaterialsBundle\VentureRawMaterialsBundle(),
            new Venture\DashBoardBundle\VentureDashBoardBundle(),
            new Venture\PackagingBundle\VenturePackagingBundle(),
            new Venture\CommonBundle\VentureCommonBundle(),
            new Venture\FinishedProductBundle\VentureFinishedProductBundle(),
            new Venture\IntermediateBundle\VentureIntermediateBundle(),
            new Venture\CustomerBundle\VentureCustomerBundle(),
            new Venture\CompetitiveProductBundle\VentureCompetitiveProductBundle(),
            new Venture\AlternateRawMaterialBundle\VentureAlternateRawMaterialBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Venture\UserBundle\VentureUserBundle(),
            new Venture\PipeLineBundle\VenturePipeLineBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
