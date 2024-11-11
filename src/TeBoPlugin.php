<?php

declare(strict_types=1);

namespace TeBo;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Log\Engine\FileLog;
use Cake\Log\Log;
use Cake\Routing\RouteBuilder;
use TeBo\Utility\Bot;

/**
 * Plugin for TeBo
 */
class TeBoPlugin extends BasePlugin
{
    public const EVENT_NEW_UPDATE = 'TeBo.newUpdate';

    public const METHOD_SEND_MESSAGE = 'sendMessage';
    public const METHOD_SEND_PHOTO = 'sendPhoto';
    public const METHOD_SEND_VIDEO = 'sendVideo';

    /**
     * Load all the plugin configuration and bootstrap logic.
     *
     * The host application is provided as an argument. This allows you to load
     * additional plugin dependencies, or attach events.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The host application
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        if (!Log::getConfig('tebo')) {
            Log::setConfig('tebo', [
                'className' => FileLog::class,
                'path' => LOGS,
                'file' => 'debug_tebo',
                'url' => env('LOG_TEBO_URL', null),
                'scopes' => ['tebo'],
                'levels' => ['notice', 'info', 'debug'],
            ]);
        }

        try {
            Configure::load('TeBo.tebo', 'default', true);
            Configure::load('tebo', 'default', true);
        } catch (\Exception $e) {
            Bot::debug($e->getMessage());
        }

        define('TEBO_CORE_PATH', ROOT . DS . 'vendor' . DS . 'arodu' . DS . 'tebo');
    }

    /**
     * Add routes for the plugin.
     *
     * If your plugin has many routes and you would like to isolate them into a separate file,
     * you can create `$plugin/config/routes.php` and delete this method.
     *
     * @param \Cake\Routing\RouteBuilder $routes The route builder to update.
     * @return void
     */
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'TeBo',
            ['path' => '/tebo'],
            function (RouteBuilder $builder) {
                $webhookRoute = '/webhook';
                $obfuscation = Configure::read('tebo.obfuscation');
                if (!empty($obfuscation) && is_string($obfuscation)) {
                    $webhookRoute = '/' . $obfuscation;
                }

                $webhookUrl = Configure::read('tebo.webhookUrl');
                $builder->connect($webhookRoute, [
                    'plugin' => $webhookUrl['plugin'],
                    'controller' => $webhookUrl['controller'],
                    'action' => $webhookUrl['action'],
                ]);
            }
        );
        parent::routes($routes);
    }

    /**
     * Add middleware for the plugin.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to update.
     * @return \Cake\Http\MiddlewareQueue
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        // Add your middlewares here

        return $middlewareQueue;
    }

    /**
     * Add commands for the plugin.
     *
     * @param \Cake\Console\CommandCollection $commands The command collection to update.
     * @return \Cake\Console\CommandCollection
     */
    public function console(CommandCollection $commands): CommandCollection
    {
        // Add your commands here

        $commands = parent::console($commands);

        return $commands;
    }

    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     * @link https://book.cakephp.org/4/en/development/dependency-injection.html#dependency-injection
     */
    public function services(ContainerInterface $container): void
    {
        // Add your services here
    }
}
