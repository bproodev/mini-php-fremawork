<?php
namespace Core;

use Tempest\Blade\Blade;

class View
{
    protected static ?Blade $engine = null;

    public static function init(
        ?string $views = null,
        ?string $cache = null
    ): void {

        $views = $views ?? [dirname(__DIR__) . '/app/Views'];
        $cache = $cache ?? dirname(__DIR__) . '/storage/cache';

        if (!is_dir($cache)) {
            mkdir($cache, 0777, true);
        }

        if (self::$engine === null) {
            self::$engine = new Blade($views, $cache);
        }
    }

    public static function render(string $view, array $data = []): string
    {
        if (self::$engine === null) {
            self::init();
        }
        // make(...)->render() is the canonical pattern.
        return self::$engine->make($view, $data)->render();
    }

    public static function display(string $view, array $data = []): void
    {
        echo self::render($view, $data);
    }
}
