<?php


namespace tests\Repositories\Eloquent;


use BookieGG\Models\User;
use BookieGG\Repositories\Eloquent\UserRepository;

class UserRepositoryTest extends \TestCase {
	public function testActivate() {
		$userRepo = new UserRepository();
		$user = $userRepo->activate(new User());
		$this->assertTrue($user->active);
	}

	public function testDeactivate() {
		$userRepo = new UserRepository();
		$user = new User();
		$user->active = true;

		$user = $userRepo->deactivate($user);

		$this->assertFalse($user->active);
	}

	public function testSave() {
		$userRepo = new UserRepository();
		$user = $userRepo->save(new User());
		$this->assertInstanceOf(User::class, $user);
	}

	public function testCreateUser() {
		$userRepo = new UserRepository();
		$user = $userRepo->createUser("a", "b", "c", "d");

		$this->assertSame("a", $user->steam_id);
		$this->assertSame("b", $user->display_name);
		$this->assertSame("c", $user->profile_name);
		$this->assertSame("d", $user->avatar_path);
	}
}
