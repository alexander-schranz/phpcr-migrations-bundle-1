<?php

/*
 * This file is part of the PHPCR Migrations package
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPCR\PhpcrMigrationsBundle\Tests\Resources\App;

use PHPCR\PhpcrMigrationsBundle\PhpcrMigrationsBundle;
use PHPCR\PhpcrMigrationsBundle\Tests\Resources\Bundle\OneTestBundle\OneTestBundle;
use PHPCR\PhpcrMigrationsBundle\Tests\Resources\Bundle\TwoTestBundle\TwoTestBundle;
use Symfony\Cmf\Component\Testing\HttpKernel\TestKernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AppKernel extends TestKernel
{
    public function configure()
    {
        $this->requireBundleSets([
            'default',
            'phpcr_odm',
        ]);

        $this->addBundles([
            new PhpcrMigrationsBundle(),
            new OneTestBundle(),
            new TwoTestBundle(),
        ]);
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->import(CMF_TEST_CONFIG_DIR.'/default.php');
        $loader->import(CMF_TEST_CONFIG_DIR.'/phpcr_odm.php');
        $loader->load(__DIR__.'/config/config.yml');
    }

    protected function prepareContainer(ContainerBuilder $container)
    {
        parent::prepareContainer($container);
        $container->setParameter('cmf_testing.bundle_fqn', 'Phpcr\PhpcrMigrationsBundle\PhpcrMigrationsBundle');
    }

    protected function getKernelParameters(): array
    {
        $kernelParameters = parent::getKernelParameters();
        $kernelParameters['kernel.root_dir'] = $this->getKernelDir();

        return $kernelParameters;
    }
}
