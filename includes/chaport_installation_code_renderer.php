<?php

declare(strict_types=1);

require_once(__DIR__ . '/chaport_app_id.php');

/** Chaport installation code renderer */
final class ChaportInstallationCodeRenderer {

    /** @var ChaportAppId Chaport App ID */
    private $appId;

    /** @var string User email */
    private $userEmail;

    /** @var string User name */
    private $userName;

    public function __construct(ChaportAppId $appId) {
        $this->appId = $appId;
    }

    /** Set user email */
    public function setUserEmail(string $email) {
        $this->userEmail = $email;
    }

    /** Set user name */
    public function setUserName(string $name) {
        $this->userName = $name;
    }

    /** Render code snippet (echo) */
    public function render() {
        require(__DIR__ . '/chaport_installation_code_snippet.php');
    }

    /** Render code snippet to a string */
    public function renderToString() {
        ob_start();
        $this->render();
        return ob_get_clean();
    }

}
