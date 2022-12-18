<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use PHPUnit\Framework\TestCase;
use App\Command\Console\CommandInterface;
use App\Factory\CommissionCalculatorCommandFactory;

class CommissionCalculatorCommandFactoryTest extends TestCase
{
    private CommissionCalculatorCommandFactory $clientFactory;

    public function setup(): void
    {
        $this->commissionCalculatorFactory = new CommissionCalculatorCommandFactory();
    }

    public function testCreate()
    {
        $client = $this->commissionCalculatorFactory->create();
        $this->assertTrue($client instanceof CommandInterface);
    }
}
