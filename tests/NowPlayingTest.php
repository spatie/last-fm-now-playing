<?php

namespace Spatie\NowPlaying\Test;

use Mockery;
use Spatie\NowPlaying\Exceptions\BadResponse;
use Spatie\NowPlaying\NowPlaying;

class NowPlayingTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Mockery\Mock|NowPlaying */
    protected $nowPlaying;

    public function setUp()
    {
        parent::setUp();

        $apiKey = 'abc123';

        $this->nowPlaying = Mockery::mock(NowPlaying::class . '[makeRequest]', [$apiKey]);
    }

    public function tearDown()
    {
        Mockery::close();

        parent::tearDown();
    }

    /** @test */
    public function it_can_get_the_current_track()
    {
        $artist = 'Can';

        $trackName = 'Spoon';

        $artwork = 'https://last.fm/an-image.jpg';

        $userName = 'murze';

        $this->nowPlaying->shouldReceive('makeRequest')
            ->withArgs([$userName])
            ->once()
            ->andReturn($this->getLastFmResponse($artist, $trackName, $artwork));

        $result = $this->nowPlaying->getTrackInfo($userName);

        $this->assertEquals(compact('artist', 'trackName', 'artwork'), $result);
    }

    /** @test */
    public function it_will_return_false_if_there_is_currently_nothing_playing()
    {
        $artist = 'Can';

        $trackName = 'Spoon';

        $artwork = 'https://last.fm/an-image.jpg';

        $userName = 'murze';

        $this->nowPlaying->shouldReceive('makeRequest')
            ->withArgs([$userName])
            ->once()
            ->andReturn($this->getLastFmResponse($artist, $trackName, $artwork, false));

        $result = $this->nowPlaying->getTrackInfo($userName);

        $this->assertFalse($result);
    }

    /** @test */
    public function it_will_raise_an_exception_when_invalid_data_is_returned()
    {
        $this->setExpectedException(BadResponse::class);

        $userName = 'murze';

        $this->nowPlaying->shouldReceive('makeRequest')
            ->withArgs([$userName])
            ->once()
            ->andReturn('bla');

        $this->nowPlaying->getTrackInfo($userName);
    }

    /**
     * @param $artist
     * @param $trackName
     * @param $artwork
     * @param bool $nowPlaying
     *
     * @return array
     */
    protected function getLastFmResponse($artist, $trackName, $artwork, $nowPlaying = true)
    {
        return ['recenttracks' => [
            'track' => [
                [
                    'artist' => ['#text' => $artist],
                    'name' => $trackName,
                    'image' => [
                        ['size' => 'extralarge', '#text' => $artwork],
                    ],
                    '@attr' => ['nowplaying' => $nowPlaying],
                ],
            ],
        ],
        ];
    }
}
