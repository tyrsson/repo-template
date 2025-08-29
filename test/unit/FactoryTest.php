<?php

declare(strict_types=1);

namespace AcmeTest\Foo;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class FactoryTest extends TestCase
{
    private $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new class implements \Laminas\ServiceManager\Factory\FactoryInterface {
            public function __invoke(ContainerInterface $container, string $requestedName, array $options = null): mixed
            {
                return new $requestedName();
            }
        };
    }

    public function testFactoryCreatesInstance(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $instance = ($this->factory)($container, TestAsset::class);
        $this->assertInstanceOf(TestAsset::class, $instance);
    }
}
