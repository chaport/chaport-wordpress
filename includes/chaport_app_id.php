<?php

declare(strict_types=1);

/** Contains Chaport App ID validated value */
final class ChaportAppId {

    /** @var string Raw App ID */
    private $appId;

    private function __construct($appId) {
        $this->appId = $appId;
    }

    public function __toString() {
        return $this->appId;
    }

    /** Constructs new App ID instance from given string */
    public static function fromString($maybeAppId) {
        if (!self::isValid($maybeAppId)) {
            throw new Exception('Invalid Chaport App ID');
        }
        return new self($maybeAppId);
    }

    /** Checks if string is a valid Chaport App ID */
    public static function isValid($maybeAppId) {
        return !!preg_match('/^[a-f\d]{24}$/i', $maybeAppId);
    }

}
