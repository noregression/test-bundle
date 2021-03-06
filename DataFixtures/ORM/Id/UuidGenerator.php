<?php

namespace NoRegression\TestBundle\DataFixtures\ORM\Id;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\UuidGenerator as BaseUuidGenerator;

class UuidGenerator extends BaseUuidGenerator
{
    /**
     * {@inheritDoc}
     */
    public function generate(EntityManager $em, $entity)
    {
        $class = $em->getClassMetadata(get_class($entity));
        $idFields = $class->getIdentifierFieldNames();
        $identifier = array();

        foreach ($idFields as $idField) {
            $value = $class->getFieldValue($entity, $idField);

            if (!isset($value)) {
                $value = $this->getGeneratedValue($em, $entity);
            }

            $identifier[$idField] = $value;

        }

        return $value;
    }

    public function getGeneratedValue(EntityManager $em, $entity)
    {
        return parent::generate($em, $entity);
    }
}
