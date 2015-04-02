<?php

/*
 * This file is part of the firebase-php package.
 *
 * (c) Jérôme Gamez <jerome@kreait.com>
 * (c) kreait GmbH <info@kreait.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Kreait\Firebase;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    protected function setUp()
    {
        $this->configuration = new Configuration();
    }

    public function testDefaultState()
    {
        $this->assertInstanceOf('\Psr\Log\LoggerInterface', $this->configuration->getLogger());
        $this->assertInstanceOf('\Ivory\HttpAdapter\HttpAdapterInterface', $this->configuration->getHttpAdapter());

        $this->assertFalse($this->configuration->hasFirebaseSecret());
    }

    /**
     * @expectedException \Kreait\Firebase\Exception\ConfigurationException
     */
    public function testGettingUndefinedSecretThrowsException()
    {
        $this->configuration->getFirebaseSecret();
    }

    public function testSetAndGetFirebaseSecret()
    {
        $this->configuration->setFirebaseSecret($secret = 'foo');

        $this->assertTrue($this->configuration->hasFirebaseSecret());
        $this->assertSame($secret, $this->configuration->getFirebaseSecret());
    }

    public function testSetAndGetHttpAdapter()
    {
        /** @var \Ivory\HttpAdapter\HttpAdapterInterface $http */
        $http = $this->prophesize('\Ivory\HttpAdapter\HttpAdapterInterface')->reveal();

        $this->configuration->setHttpAdapter($http);

        $this->assertSame($http, $this->configuration->getHttpAdapter());
    }

    public function testSetAndGetLogger()
    {
        /** @var \Psr\Log\LoggerInterface $logger */
        $logger = $this->prophesize('\Psr\Log\LoggerInterface')->reveal();

        $this->configuration->setLogger($logger);

        $this->assertSame($logger, $this->configuration->getLogger());
    }
}
