<?php namespace Arcanedev\SeoHelper\Tests\Entities;

use Arcanedev\SeoHelper\Contracts\Renderable;
use Arcanedev\SeoHelper\Entities\Title;
use Arcanedev\SeoHelper\Tests\TestCase;

/**
 * Class     TitleTest
 *
 * @package  Arcanedev\SeoHelper\Tests\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TitleTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Title */
    protected $title;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $config      = $this->getTitleConfig();
        $this->title = new Title($config);
    }

    public function tearDown()
    {
        unset($this->title);

        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(Title::class,      $this->title);
        $this->assertInstanceOf(Renderable::class, $this->title);
    }

    /** @test */
    public function it_can_get_default_title()
    {
        $this->assertEquals(
            $this->getDefaultTitle(), $this->title->getTitleOnly()
        );
    }

    /** @test */
    public function it_can_set_and_get_title()
    {
        $title = 'Awesome Title';

        $this->title->set($title);

        $this->assertEquals($title, $this->title->getTitleOnly());
    }

    /** @test */
    public function it_can_get_default_site_name()
    {
        $this->assertEquals(
            $this->getDefaultSiteName(),
            $this->title->getSiteName()
        );
    }

    /** @test */
    public function it_can_set_and_get_site_name()
    {
        $siteName = 'Company name';

        $this->title->setSiteName($siteName);

        $this->assertEquals($siteName, $this->title->getSiteName());
    }

    /** @test */
    public function it_can_get_default_separator()
    {
        $this->assertEquals(
            $this->getDefaultSeparator(), $this->title->getSeparator()
        );
    }

    /** @test */
    public function it_can_get_and_set_separator()
    {
        $separator = '|';
        $this->title->setSeparator($separator);

        $this->assertEquals($separator, $this->title->getSeparator());

        $separator = ' _ ';
        $this->title->setSeparator($separator);

        $this->assertEquals(trim($separator), $this->title->getSeparator());
    }

    /** @test */
    public function it_can_get_default_title_position()
    {
        $this->assertEquals(
            array_get($this->getTitleConfig(), 'first', true),
            $this->title->isTitleFirst()
        );
    }

    /** @test */
    public function it_can_switch_title_position()
    {
        $this->assertTrue($this->title->isTitleFirst());

        $this->title->setLast();

        $this->assertFalse($this->title->isTitleFirst());

        $this->title->setFirst();

        $this->assertTrue($this->title->isTitleFirst());
    }

    /** @test */
    public function it_can_render_default_title()
    {
        $title    = $this->getDefaultTitle();
        $expected = "<title>$title</title>";

        $this->assertEquals($expected, $this->title->render());
        $this->assertEquals($expected, (string) $this->title);
    }

    /** @test */
    public function it_can_render_custom_titles()
    {
        $title     = 'Awesome Title';
        $siteName  = 'Company name';
        $separator = '|';

        $this->title
            ->set($title)
            ->setSiteName($siteName)
            ->setSeparator($separator);
        $expected = "<title>$title $separator $siteName</title>";

        $this->assertEquals($expected, $this->title->render());
        $this->assertEquals($expected, (string) $this->title);

        $this->title->setLast();
        $expected = "<title>$siteName $separator $title</title>";

        $this->assertEquals($expected, $this->title->render());
        $this->assertEquals($expected, (string) $this->title);

        $separator = '|';
        $this->title->setSeparator($separator);
        $expected  = "<title>$siteName $separator $title</title>";

        $this->assertEquals($expected, $this->title->render());
        $this->assertEquals($expected, (string) $this->title);

        $this->title->setFirst();
        $expected = "<title>$title $separator $siteName</title>";

        $this->assertEquals($expected, $this->title->render());
        $this->assertEquals($expected, (string) $this->title);

        $this->title->setSiteName('');
        $expected = "<title>$title</title>";

        $this->assertEquals($expected, $this->title->render());
        $this->assertEquals($expected, (string) $this->title);

        $this->title->setLast();
        $expected = "<title>$title</title>";

        $this->assertEquals($expected, $this->title->render());
        $this->assertEquals($expected, (string) $this->title);

        $this->title
            ->setSiteName($siteName)
            ->setSeparator('')
            ->setFirst();
        $expected = "<title>$title $siteName</title>";

        $this->assertEquals($expected, $this->title->render());
        $this->assertEquals($expected, (string) $this->title);

        $this->title->setLast();
        $expected = "<title>$siteName $title</title>";

        $this->assertEquals($expected, $this->title->render());
        $this->assertEquals($expected, (string) $this->title);
    }

    /** @test */
    public function it_can_make_title_tag()
    {
        $title     = 'Awesome title';
        $siteName  = 'Company Name';
        $separator = '|';

        $this->title = Title::make($title, $siteName, $separator);

        $this->assertInstanceOf(Title::class, $this->title);

        $this->assertEquals($title,     $this->title->getTitleOnly());
        $this->assertEquals($siteName,  $this->title->getSiteName());
        $this->assertEquals($separator, $this->title->getSeparator());

        $expected = '<title>Awesome title | Company Name</title>';

        $this->assertEquals($expected, $this->title->render());
        $this->assertEquals($expected, (string) $this->title);
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\SeoHelper\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage  The title must be a string value, [NULL] is given.
     */
    public function it_must_throw_title_exception_on_invalid_type()
    {
        $this->title->set(null);
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\SeoHelper\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage  The title is required and must not be empty.
     */
    public function it_must_throw_title_exception_on_empty_title()
    {
        $this->title->set('  ');
    }

    /** @test */
    public function it_can_set_and_get_max_length()
    {
        $max = 50;

        $this->title->setMax($max);

        $this->assertEquals($max, $this->title->getMax());
    }

    /** @test */
    public function it_can_render_long_title()
    {
        $title = 'This is my long and awesome title that gonna blown your mind.';
        $max   = $this->getDefaultMax();

        $this->title->set($title)->setMax($max);
        $expected = '<title>' . str_limit($title, $max) . '</title>';

        $this->assertEquals($expected, $this->title->render());
        $this->assertEquals($expected, (string) $this->title);
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\SeoHelper\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage  The title maximum lenght must be integer.
     */
    public function it_must_throw_invalid_max_lenght_type()
    {
        $this->title->setMax(null);
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\SeoHelper\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage  The title maximum lenght must be greater 0.
     */
    public function it_must_throw_invalid_max_lenght_value()
    {
        $this->title->setMax(0);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Title config.
     *
     * @return array
     */
    private function getTitleConfig()
    {
        return $this->getSeoHelperConfig('title', []);
    }

    /**
     * Get default title.
     *
     * @param  string  $default
     *
     * @return string
     */
    private function getDefaultTitle($default = '')
    {
        return $this->getSeoHelperConfig('title.default', $default);
    }

    /**
     * Get default site name.
     *
     * @param  string  $default
     *
     * @return string
     */
    private function getDefaultSiteName($default = '')
    {
        return $this->getSeoHelperConfig('title.site-name', $default);
    }

    /**
     * Get default separator.
     *
     * @param  string  $default
     *
     * @return string
     */
    private function getDefaultSeparator($default = '-')
    {
        return $this->getSeoHelperConfig('title.separator', $default);
    }

    /**
     * Get title max length.
     *
     * @param  int  $default
     *
     * @return int
     */
    private function getDefaultMax($default = 55)
    {
        return $this->getSeoHelperConfig('title.max', $default);
    }
}
