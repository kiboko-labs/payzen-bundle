<?php

namespace Kiboko\SyliusPayzenBundle;

use Kiboko\SyliusPayzenBundle\DependencyInjection\KibokoSyliusPayzenExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class KibokoSyliusPayzenBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new KibokoSyliusPayzenExtension();
        }

        return $this->extension;
    }
}
