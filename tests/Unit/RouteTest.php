<?php
// Ref: https://phpunit.de/manual/current/en/writing-tests-for-phpunit.html

use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    const ROOT_URL = 'http://localhost/';
    /**
     * Test all available routes.
     *
     * @return void
     */
    public function testRoutes()
    {
        // Home page should contain app name from .env
        $page = file_get_contents(self::ROOT_URL);
        $this->assertContains('DJM Lessons', $page);

        // Restricted pages
        // Note: Vue cannot be tested here
        $page = file_get_contents(self::ROOT_URL . '123456');
        $this->assertContains('folderCode: \'123456\'', $page);

        // Users should not have access to these
        $internalAssets = [
            '987456',
            '.env',
            'api',
            'api/modules',
            'audio',
            'audio/Audio-Type-2/Audio-in-2nd-group.mp3',
            'config',
            'components',
            'views'
        ];
        foreach ($internalAssets as $asset) {
            $page = file_get_contents(self::ROOT_URL . $asset);
            $this->assertContains('Page not found!', $page);
        }
    }
}
