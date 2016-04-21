<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
    * The base URL to use while testing the application.
    *
    * @var string
    */
    protected $baseUrl = 'http://';

    protected $faker = null;

    /**
    * Model Classes
    */
    protected $GAUser = null;
    protected $GASalesPerson = null;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Test setup
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->baseUrl = 'http://'.env('APP_HOST');

        $this->faker = Faker\Factory::create();
        $this->GAUser = factory(GAPlatform\Models\GAUser::class)->make();
        $this->GASalesPerson = factory(GAPlatform\Models\GASalesPerson::class)->make();
    }  

    /**
     * Test teardown
     *
     * @return void
     */
    public function teardown()
    {
        
    }  
}
