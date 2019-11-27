<?php


namespace nrslib\ClarcLaravelPlugin\Commands\Shared\Menu;


class ClarcCommandSharedMenu
{
    /**
     * @var ClarcCommandSharedMenuOption[]
     */
    private $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function interact(string $selector): bool
    {
        foreach ($this->options as $option)
        {
            if ($option->match($selector))
            {
                $option->interact();
                return true;
            }
        }

        return false;
    }
}