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
            new FOS\UserBundle\FOSUserBundle(),
            new Ornicar\GravatarBundle\OrnicarGravatarBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Casecenter\UserBundle\CasecenterUserBundle(),
            new Casecenter\AdministrationBundle\CasecenterAdministrationBundle(),
            new Casecenter\DashboardBundle\CasecenterDashboardBundle(),
            new Casecenter\SupportBundle\CasecenterSupportBundle(),
            new Casecenter\PlanningBundle\CasecenterPlanningBundle(),
            new Casecenter\AdvertisingBundle\CasecenterAdvertisingBundle(),
            new Casecenter\ProjectBundle\CasecenterProjectBundle(),
            new Casecenter\ReportBundle\CasecenterReportBundle(),
            new Casecenter\WikiBundle\CasecenterWikiBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            $bundles[] = new CoreSphere\ConsoleBundle\CoreSphereConsoleBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
