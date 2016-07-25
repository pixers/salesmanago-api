<?php

namespace Pixers\SalesManagoAPI\Tests\Service;

use Pixers\SalesManagoAPI\Service\RuleService;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class RuleServiceTest extends AbstractServiceTest
{
    /**
     * @var RuleService
     */
    protected static $ruleService;

    /**
     * Setup rule service.
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$ruleService = new RuleService(self::$salesManagoClient);
    }

    public function testCreate()
    {
        $data = [
            'shared' => true,
            'active' => true,
            'deleted' => false,
            'delayConditionsCheck' => true,
            'delayConditionsValue' => 1,
            'delayConditionsPeriod' => 'DAY',
            'name' => 'sadsadasdasd',
            'maxFireTimes' => 111,
            'minFireInterval' => 2,
            'checkAgain' => true,
            'checkAgainAfter' => 2,
            'events' => [],
            'conditions' => [],
            'actions' => []
        ];

        $response = self::$ruleService->create(self::$config['owner'], $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('ruleId', $response);
        $this->assertInternalType('string', $response->ruleId);
        $this->assertNotEmpty($response->ruleId);
    }
}
