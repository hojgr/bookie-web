<?php


namespace tests\Commands;


use BookieGG\Commands\SubscribeUserToBeta;
use BookieGG\Models\BetaSubscription;
use BookieGG\Models\User;

class SubscribeUserToBetaTest extends \TestCase {
    public function testSubscribe_call_save() {
        $CI = $this;
        $args = ['name' => 'John Doe', 'email' => 'e@ma.il'];

        $has_one_or_many = \Mockery::mock('Illuminate\Database\Eloquent\Relations\HasOneOrMany');
        $has_one_or_many->shouldReceive('save')->once()->with(\Mockery::on(function(BetaSubscription $model) use ($CI, $args) {
            $this->assertSame($args['name'], $model->name);
            $this->assertSame($args['email'], $model->email);
            return true;
        }));

        $user = \Mockery::mock('BookieGG\Models\User');
        $user->shouldReceive('getAttribute')->once()->with('subscription')->andReturnNull();
        $user->shouldReceive('subscription')->once()->andReturn($has_one_or_many);

        $subscribe_user_to_beta_command = new SubscribeUserToBeta($user, $args);
        $subscribe_user_to_beta_command->handle();

        $user->mockery_verify();
        $has_one_or_many->mockery_verify();
    }

    public function testSubscribe_dont_call_save() {
        $this->setExpectedException('BookieGG\Exceptions\UserAlreadySubscribed');
        $has_one_or_many = \Mockery::mock('Illuminate\Database\Eloquent\Relations\HasOneOrMany');
        $has_one_or_many->shouldReceive('save')->never();

        $user = \Mockery::mock('BookieGG\Models\User');
        $user->shouldReceive('getAttribute')->once()->with('subscription')->andReturn($has_one_or_many);
        $user->shouldReceive('getAttribute')->once()->with('id')->andReturn(1);

        $subscribe_user_to_beta_command = new SubscribeUserToBeta($user, []);
        $subscribe_user_to_beta_command->handle();

        $user->mockery_verify();
        $has_one_or_many->mockery_verify();
    }
}
