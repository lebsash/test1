<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GAUserTest extends TestCase
{
    /**
     * Check for valid record when getting a user
     *
     * @return void
     */
    public function testgetUserInfo()
    {
        $user = $this->GAUser->toArray();
        $this->assertArrayHasKey('UserID', $user);
    }
}
