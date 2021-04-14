<?php

namespace Webloper\Gravatar\Tests;

use PHPUnit\Framework\TestCase;
use Webloper\Gravatar\Gravatar;

class GravatarTest extends TestCase
{
    /** @test */
    public function it_can_convert_email_to_gravatar()
    {
        $email = 'webloper@gmail.com';

        $this->gravatar = new Gravatar($email);

        $url = $this->gravatar->url();

        $this->assertNotNull($url, 'message');
    }
}
