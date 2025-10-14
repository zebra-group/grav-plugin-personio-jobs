<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;
use Grav\Plugin\PersonioJobs\Utils;
use Symfony\Component\VarDumper\Cloner\DumperInterface;

/**
 * Class PersonioJobsPlugin
 * @package Grav\Plugin
 */
class PersonioJobsPlugin extends Plugin
{
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onPluginsInitialized' => [
                // Uncomment following line when plugin requires Grav < 1.7
                // ['autoload', 100000],
                ['onPluginsInitialized', 0]
            ],
            'onTwigSiteVariables'   => ['onTwigSiteVariables', 0],
            'onDirectusSyncSuccess' => ['createIndex', 0],
            'onDirectusRestore'     => ['createIndex', 0],
            'onAfterCacheClear'     => ['createIndex', 0],
        ];
    }

    /**
     * Composer autoload
     *
     * @return ClassLoader
     */
    public function autoload(): ClassLoader
    {
        return require __DIR__ . '/vendor/autoload.php';
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized(): void
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        // Enable the main events we are interested in
        $this->enable([
            // Put your main events here
        ]);
    }

    public function onTwigSiteVariables()
    {
        require_once __DIR__ . '/classes/Utils.php';
        $this->grav['twig']->twig_vars['personio'] = new Utils;
    }

    public function createIndex()
    {
        $this->grav['log']->info('Personio: createIndex');
        $utils = new Utils;
        $jobs = $utils->fetchJobs();
        $utils->setCache( $jobs );
    }
}
