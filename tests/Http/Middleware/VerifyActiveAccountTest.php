<?php


namespace tests\Http\Middleware;


use BookieGG\Models\User;

class VerifyActiveAccountTest extends \TestCase {
    public function testNotActive_beta_page() {
        $response = $this->call('GET', route("beta_home"));
        $this->assertFalse($response->isRedirection());
    }

    public function testNotActive_home_page() {
        $response = $this->call('GET', route("home"));
        $this->assertTrue($response->isRedirect(route("beta_home")));
    }

    public function testActive_home_page() {
        $test_user = new User();
        $test_user->active = true;

        \Auth::shouldReceive('user')->twice()->andReturn($test_user);

        $response = $this->call('GET', route("home"));
        $this->assertFalse($response->isRedirection());
    }
}
