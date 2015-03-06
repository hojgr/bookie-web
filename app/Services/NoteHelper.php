<?php


namespace BookieGG\Services;


use BookieGG\Contracts\NoteHelperInterface;

class NoteHelper implements NoteHelperInterface {

	public function format($in)
	{
		$in = $this->formatBasic($in, '\\*', 'b');
		$in = $this->formatBasic($in, '_', 'i');
		return $in;
	}

	public function formatBasic($in, $symbol, $repl) {
		return preg_replace("/$symbol([^$symbol]+)$symbol/", "<$repl>$1</$repl>", $in);
	}
}