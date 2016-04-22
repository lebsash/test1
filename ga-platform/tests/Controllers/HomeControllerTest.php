<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeControllerTest extends TestCase
{
    /**
     * Check homepage content
     *
     * @return void
     */
    public function testHomePage()
    {
        $this->visit('/')->see('Great Agent');
    }

    /**
     * Login main page
     *
     * @return void
     */
    public function testMainLoginPage()
    {
        $this->visit('/login')->see('Sign In');
    }

    /**
     * Login main page - terms unchecked
     *
     * @return void
     */
    public function testMainLoginPageNoTerms()
    {
        $this->post('login', ['email'=>$this->faker->email])
             ->see('Terms of Service Agreement is required');
    }

    /**
     * Login main page - no password
     *
     * @return void
     */
    public function testMainLoginPageNoPassword()
    {
        $this->post('login', ['email'=>$this->faker->email,'termsOfService'=>'terms'])
             ->see('Password is missing');
    }

    /**
     * Login main page - invalid account
     *
     * @return void
     */
    public function testMainLoginPageInvalidAccount()
    {
        $this->post('login', ['email'=>$this->faker->email,
                              'password'=>$this->faker->password,
                              'termsOfService'=>'terms'
                             ])
             ->see('Authorization failed');
    }

    /**
     * Login main page - show signature form
     *
     * @return void
     */

}
