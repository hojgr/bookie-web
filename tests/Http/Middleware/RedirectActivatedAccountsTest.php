<?php


namespace tests\Http\Middleware;


use BookieGG\Models\User;

class RedirectActivatedAccountsTest extends \TestCase {
    /**
     * states
     * - not authed
     * - authed not active
     * - authed active
     *
     * active accesses beta_home -> redirect to home
     */
    public function testNotAuthed_beta_page() {
        $response = $this->call('GET', route("beta_home"));
        $this->assertFalse($response->isRedirection());
    }

    public function testAuthedNotActive_beta_page() {
        $test_user = new User();
        $test_user->active = false;

        \Auth::shouldReceive($test_user)->twice()->andReturn($test_user);

        $response = $this->call('GET', route("beta_home"));
        $this->assertFalse($response->isRedirection());
    }

    public function testAuthenticatedActive_beta_page() {
        $test_user = new User();
        $test_user->active = true;

        \Auth::shouldReceive('user')->twice()->andReturn($test_user);

        $response = $this->call('GET', route("beta_home"));
        $this->assertTrue($response->isRedirect(route('home')));
    }
}