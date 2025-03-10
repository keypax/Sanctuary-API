<?php

namespace App\Controller\V1;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class ApiAbstractController extends AbstractController
{
    private SerializationContext $context;
    public function __construct(private SerializerInterface $serializer) {
        $this->context = SerializationContext::create()->setSerializeNull(true);
    }

    protected function toJson(mixed $data)
    {
        return $this->serializer->serialize(
            $data,
            'json',
            $this->context
        );
    }
}