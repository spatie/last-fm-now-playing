<?php

namespace Spatie\NowPlaying\Test;

use Mockery;
use PHPUnit\Framework\TestCase;
use Spatie\NowPlaying\Exceptions\BadResponse;
use Spatie\NowPlaying\NowPlaying;

class NowPlayingTest extends TestCase
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

        $album = 'Kitchen';

        $trackName = 'Spoon';

        $artwork = 'https://last.fm/an-image.jpg';

        $url = 'https://last.fm/a-song';

        $userName = 'murze';

        $this->nowPlaying->shouldReceive('makeRequest')
            ->withArgs([$userName])
            ->once()
            ->andReturn($this->getLastFmResponse($artist, $album, $trackName, $artwork, $url));

        $result = $this->nowPlaying->getTrackInfo($userName);

        $this->assertEquals(compact('artist', 'album', 'trackName', 'artwork', 'url'), $result);
    }

    /** @test */
    public function it_will_return_false_if_there_is_currently_nothing_playing()
    {
        $artist = 'Can';

        $album = 'Kitchen';

        $trackName = 'Spoon';

        $artwork = 'https://last.fm/an-image.jpg';

        $url = 'https://last.fm/a-song';

        $userName = 'murze';

        $this->nowPlaying->shouldReceive('makeRequest')
            ->withArgs([$userName])
            ->once()
            ->andReturn($this->getLastFmResponse($artist, $album, $trackName, $artwork, $url, false));

        $result = $this->nowPlaying->getTrackInfo($userName);

        $this->assertFalse($result);
    }

    /** @test */
    public function it_will_return_false_if_there_is_an_empty_response()
    {
        $userName = 'murze';

        $this->nowPlaying->shouldReceive('makeRequest')
            ->withArgs([$userName])
            ->once()
            ->andReturn($this->getLastFmResponseWithEmptyValues());

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
     * @param $album
     * @param $trackName
     * @param $artwork
     * @param $url
     * @param bool $nowPlaying
     *
     * @return array
     */
    protected function getLastFmResponse($artist, $album, $trackName, $artwork, $url, $nowPlaying = true)
    {
        return ['recenttracks' => [
            'track' => [
                [
                    'artist' => ['#text' => $artist],
                    'album' => ['#text' => $album],
                    'name' => $trackName,
                    'image' => [
                        ['size' => 'extralarge', '#text' => $artwork],
                    ],
                    'url' => $lastTrack['url'],
                    '@attr' => ['nowplaying' => $nowPlaying],
                ],
            ],
        ],
        ];
    }

    /**
     * @return array
     */
    protected function getLastFmResponseWithEmptyValues()
    {
        return [
            "recenttracks" => [
                "track" => [],
                "@attr" => [
                    "user" => "murze",
                    "page" => "1",
                    "perPage" => "1",
                    "totalPages" => "0",
                    "total" => "0",
                ],
            ],
        ];
    }
}
