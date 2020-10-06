<?php

namespace Boblarouche\Traduction\Tests;

use Orchestra\Testbench\TestCase;
use Boblarouche\Traduction\TraductionServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [TraductionServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
