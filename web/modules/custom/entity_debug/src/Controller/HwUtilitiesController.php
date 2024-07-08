<?php

namespace Drupal\entity_debug\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a HW Utilities page.
 */
class HwUtilitiesController extends ControllerBase
{

    /**
     * The module handler service.
     *
     * @var \Drupal\Core\Extension\ModuleHandlerInterface
     */
    protected $moduleHandler;

    /**
     * Constructs a HwUtilitiesController object.
     *
     * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
     *   The module handler service.
     */
    public function __construct(ModuleHandlerInterface $module_handler)
    {
        $this->moduleHandler = $module_handler;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('module_handler')
        );
    }

    /**
     * Returns a page listing links to all modules in the "Hello World" package.
     *
     * @return array
     *   A render array containing the HW Utilities page content.
     */
    public function content()
    {
        $modules = system_rebuild_module_data();
        $links = [];

        foreach ($modules as $module_id => $module) {
            if ($module->info['package'] === 'Hello World') {
                // Create a link to the module's configuration page, if it exists.
                $route_name = "entity_debug.{$module_id}_settings";
                $url = Url::fromRoute($route_name, [], ['absolute' => TRUE]);
                if (\Drupal::service('router.route_provider')->getRouteByName($route_name, FALSE)) {
                    $links[] = [
                        '#type' => 'link',
                        '#title' => $module->info['name'],
                        '#url' => $url,
                    ];
                }
            }
        }

        return [
            '#theme' => 'item_list',
            '#items' => $links,
            '#title' => $this->t('HW Utilities'),
        ];
    }
}
