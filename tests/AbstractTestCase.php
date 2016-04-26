<?php

namespace TomLingham\Tests\Searchy;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use TomLingham\Searchy\SearchyServiceProvider;

/**
 * This is the abstract test case class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
abstract class AbstractTestCase extends AbstractPackageTestCase
{
    /**
     * Get the service provider class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string
     */
    protected function getServiceProviderClass($app)
    {
        return SearchyServiceProvider::class;
    }
}
