<?php

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../includes/chaport_app_id.php');

final class ChaportAppIdTest extends TestCase {

    private const INVALID_APP_ID = 'bad_app_id';
    private const VALID_APP_ID = '1234567890abcdef12345678';

    public function testCanValidateAppId() {
        $this->assertFalse(ChaportAppId::isValid(self::INVALID_APP_ID));
        $this->assertTrue(ChaportAppId::isValid(self::VALID_APP_ID));
    }

    public function testFailsToConstructFromInvalidAppId() {
        $this->expectExceptionMessage('Invalid Chaport App ID');
        ChaportAppId::fromString(self::INVALID_APP_ID);
    }

    public function testAbleToConstructFromValidAppId() {
        $this->assertInstanceOf(
            ChaportAppId::class,
            ChaportAppId::fromString(self::VALID_APP_ID)
        );
    }

    public function testCanBeCastedToString() {
        $appId = ChaportAppId::fromString(self::VALID_APP_ID);
        $this->assertEquals(self::VALID_APP_ID, "$appId");
    }

}
