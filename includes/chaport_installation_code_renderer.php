<?php

require_once(dirname(__FILE__) . '/chaport_app_id.php');

/** Chaport installation code renderer */
final class ChaportInstallationCodeRenderer {

    /** @var ChaportAppId Chaport App ID */
    private $appId;

    /** @var string User email */
    private $userEmail;

    /** @var string User name */
    private $userName;

    public function __construct($appId) {
        if (!($appId instanceof ChaportAppId)) {
            throw new Error('Expecting appId to be instance of ChaportAppId');
        }
        $this->appId = $appId;
    }

    /** Set user email */
    public function setUserEmail($email) {
        if (!is_string($email)) {
            throw new Exception('Email should be a string');
        }
        $this->userEmail = $email;
    }

    /** Set user name */
    public function setUserName($name) {
        if (!is_string($name)) {
            throw new Exception('Name should be a string');
        }
        $this->userName = $name;
    }

    /** Render code snippet (echo) */
    public function render() {
        require(dirname(__FILE__) . '/chaport_installation_code_snippet.php');
    }

    /** Render code snippet to a string */
    public function renderToString() {
        ob_start();
        $this->render();
        return ob_get_clean();
    }

}
