<?php

namespace Drupal\entity_debug;

use Drupal\Core\Entity\EntityTypeManager as CoreEntityTypeManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class EntityTypeManager
 *
 * Extends the core EntityTypeManager to add debugging information.
 */
class EntityTypeManager extends CoreEntityTypeManager
{

    /**
     * The logger service.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Constructs a new EntityTypeManager object.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     *   The container interface.
     * @param \Psr\Log\LoggerInterface $logger
     *   The logger service.
     */
    public function __construct(ContainerInterface $container, LoggerInterface $logger)
    {
        parent::__construct($container->get('container.namespaces'), $container->get('cache.entity_type'), $container->get('module_handler'), $container->get('parameter_bag'), $container->get('entity_type.repository'));
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition($entity_type_id, $exception_on_invalid = TRUE)
    {
        try {
            return parent::getDefinition($entity_type_id, $exception_on_invalid);
        } catch (\Exception $e) {
            $this->logger->error('Entity type not found: @type. Error: @message', ['@type' => $entity_type_id, '@message' => $e->getMessage()]);
            throw $e;
        }
    }
}
