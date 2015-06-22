<?php


namespace BookieGG\Services;


use BookieGG\Contracts\NoteHelperInterface;

class NoteHelper implements NoteHelperInterface {

    public function format($in)
    {
        $in = $this->formatBasic($in, '\\*', 'b');
        $in = $this->formatBasic($in, '_', 'i');

        $in = $this->formatColor($in, 'red', 'red');
        $in = $this->formatColor($in, 'green', 'green');
        $in = $this->formatColor($in, 'blue', '#02a4d9');

        return $in;
    }

    public function formatBasic($in, $symbol, $repl) {
        return preg_replace("/$symbol(.*?)$symbol/", "<$repl>$1</$repl>", $in);
    }

    public function formatColor($in, $name, $color) {
        return preg_replace("~<$name>(.*?)</$name>~", "<span style='color: $color'>$1</span>", $in);
    }
}