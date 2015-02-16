<?php namespace BookieGG\Console\Commands;

use BookieGG\Models\User;
use Symfony\Component\Console\Input\InputOption;

class UserList extends BaseCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'user:list';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Prints list of users';

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$users = User::where("id", '>=', $this->option('start'))->take($this->option('length'))->get();

		$count = count($users);

		$this->line("<yellow>Printing " . $count . " user" . ($count > 1 ? "s" : "") . "</yellow>");
		$this->line($this->formatList("#", "STEAM ID", "Display name", "Active", "green"));
		foreach($users as $user) {
			$this->line($this->formatList($user->id, $user->steam_id, $user->display_name, $user->active));

		}
	}

	public function formatList($id, $steam_id, $display_name, $active, $column_color = null, $delim_color = "blue") {
		if($delim_color != null)
			$delimiter = "<$delim_color>|</$delim_color> ";
		else
			$delimiter = "| ";

		if($column_color) {
			$id = "<$column_color>" . str_pad($id, 5) . "</$column_color>";
			$steam_id = "<$column_color>" . str_pad($steam_id, 20) . "</$column_color>";
			$display_name = "<$column_color>" . str_pad($display_name, 40) . "</$column_color>";
		} else {
			$id = str_pad($id, 5);
			$steam_id = str_pad($steam_id, 20);
			$display_name = str_pad($display_name, 40);
		}

		if(is_numeric($active)) {
			$active_color = ($active ? "back-green" : "back-red");
			$active = "<$active_color>      </$active_color>";
		}

		return $id . $delimiter . $steam_id . $delimiter . $display_name . $delimiter . $active . "</$delim_color>";
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['start', 's', InputOption::VALUE_OPTIONAL, 'Start of list (id)', 0],
			['length', 'l', InputOption::VALUE_OPTIONAL, 'Length of list', 50],
		];
	}

}
