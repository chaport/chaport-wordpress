<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../includes/chaport_app_id.php');
require_once(__DIR__ . '/../includes/chaport_installation_code_renderer.php');

final class ChaportInstallationCodeRendererTest extends TestCase {

    private const APP_ID = '1234567890abcdef12345678';

    public function testRendersCodeSnippet() {
        $renderer = new ChaportInstallationCodeRenderer(ChaportAppId::fromString(self::APP_ID));
        $snippet = $renderer->renderToString();
        $this->assertContains(self::APP_ID, $snippet);
        $this->assertContains('Chaport Live Chat code', $snippet);
        $this->assertContains('script type="text/javascript"', $snippet);
    }

    public function testRendersNameAndEmailWhenAvailable() {
        $renderer = new ChaportInstallationCodeRenderer(ChaportAppId::fromString(self::APP_ID));
        $snippet = $renderer->renderToString();
        $this->assertNotContains('w.chaport.email', $snippet);
        $this->assertNotContains('w.chaport.name', $snippet);
        $renderer->setUserEmail('john.doe@example.com');
        $renderer->setUserName('John Doe');
        $snippet = $renderer->renderToString();
        $this->assertContains('w.chaport.email = \'john.doe@example.com\'', $snippet);
        $this->assertContains('w.chaport.name = \'John Doe\'', $snippet);
    }

}
