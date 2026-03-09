<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class TimezoneTest extends TestCase
{
    /**
     * Test default timezone without cookie.
     */
    public function test_default_timezone_is_used_when_no_cookie_present(): void
    {
        // Pastikan config awal (simulasi state server)
        Config::set('app.timezone', 'Asia/Jakarta');
        date_default_timezone_set('Asia/Jakarta');

        // Allow redirect
        $response = $this->get('/');

        // Assert timezone tetap default
        $this->assertEquals('Asia/Jakarta', Config::get('app.timezone'));
        $this->assertEquals('Asia/Jakarta', date_default_timezone_get());
    }

    /**
     * Test timezone change via cookie.
     */
    public function test_timezone_is_set_from_cookie(): void
    {
        $targetTimezone = 'America/New_York';

        $response = $this->withCookie('user_timezone', $targetTimezone)
                         ->get('/');

        // Assert timezone berubah sesuai cookie
        $this->assertEquals($targetTimezone, Config::get('app.timezone'));
        $this->assertEquals($targetTimezone, date_default_timezone_get());
        
        // Verifikasi offset waktu berbeda
        // Jakarta UTC+7, NY UTC-5 (approx)
        $now = now();
        $this->assertEquals($targetTimezone, $now->timezone->getName());
    }

    /**
     * Test invalid timezone cookie is ignored.
     */
    public function test_invalid_timezone_cookie_is_ignored(): void
    {
        Config::set('app.timezone', 'Asia/Jakarta');
        date_default_timezone_set('Asia/Jakarta');

        $response = $this->withCookie('user_timezone', 'Invalid/Timezone')
                         ->get('/');

        $this->assertEquals('Asia/Jakarta', Config::get('app.timezone'));
        $this->assertEquals('Asia/Jakarta', date_default_timezone_get());
    }
}
