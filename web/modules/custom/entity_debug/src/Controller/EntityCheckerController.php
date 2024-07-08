<?php

namespace Drupal\entity_debug\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides an Entity Checker page.
 */
class EntityCheckerController extends ControllerBase
{

    /**
     * The entity type manager service.
     *
     * @var \Drupal\Core\Entity\EntityTypeManagerInterface
     */
    protected $entityTypeManager;

    /**
     * Constructs an EntityCheckerController object.
     *
     * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
     *   The entity type manager service.
     */
    public function __construct(EntityTypeManagerInterface $entity_type_manager)
    {
        $this->entityTypeManager = $entity_type_manager;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('entity_type.manager')
        );
    }

    /**
     * Returns a page with a list of all known entities.
     *
     * @return array
     *   A render array containing the list of entities.
     */
    public function content()
    {
        $entity_types = $this->entityTypeManager->getDefinitions();
        $output = '<h2>Known Entity Types</h2><ul>';
        foreach ($entity_types as $entity_type_id => $entity_type) {
            $output .= '<li>' . $entity_type_id . ': ' . $entity_type->getLabel() . '</li>';
        }
        $output .= '</ul>';

        return [
            '#markup' => $output,
        ];
    }
}
