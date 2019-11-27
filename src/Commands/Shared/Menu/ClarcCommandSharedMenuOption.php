<?php


namespace nrslib\ClarcLaravelPlugin\Commands\Shared\Menu;


abstract class ClarcCommandSharedMenuOption
{
    private $selector;
    private $name;

    /**
     * ClarcCommandSharedMenuOption constructor.
     * @param $selector
     * @param $name
     */
    public function __construct($selector, $name)
    {
        $this->selector = $selector;
        $this->name = $name;
    }

    public function match(string $word): bool
    {
        return strtolower($word) === strtolower($this->selector);
    }

    public function toString()
    {
        return $this->selector . '. ' . $this->name;
    }

    public abstract function interact();
}