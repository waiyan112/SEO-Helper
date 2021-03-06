<?php namespace Arcanedev\SeoHelper;

/**
 * Class     SeoHelper
 *
 * @package  Arcanedev\SeoHelper
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SeoHelper implements Contracts\SeoHelper
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The SeoMeta instance.
     *
     * @var \Arcanedev\SeoHelper\Contracts\SeoMeta
     */
    private $seoMeta;

    /**
     * The SeoOpenGraph instance.
     *
     * @var \Arcanedev\SeoHelper\Contracts\SeoOpenGraph
     */
    private $seoOpenGraph;

    /**
     * The SeoTwitter instance.
     *
     * @var \Arcanedev\SeoHelper\Contracts\SeoTwitter
     */
    private $seoTwitter;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make SeoHelper instance.
     *
     * @param  \Arcanedev\SeoHelper\Contracts\SeoMeta       $seoMeta
     * @param  \Arcanedev\SeoHelper\Contracts\SeoOpenGraph  $seoOpenGraph
     * @param  \Arcanedev\SeoHelper\Contracts\SeoTwitter    $seoTwitter
     */
    public function __construct(
        Contracts\SeoMeta      $seoMeta,
        Contracts\SeoOpenGraph $seoOpenGraph,
        Contracts\SeoTwitter   $seoTwitter
    ) {
        $this->setSeoMeta($seoMeta);
        $this->setSeoOpenGraph($seoOpenGraph);
        $this->setSeoTwitter($seoTwitter);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get SeoMeta instance.
     *
     * @return \Arcanedev\SeoHelper\Contracts\SeoMeta
     */
    public function meta()
    {
        return $this->seoMeta;
    }

    /**
     * Set SeoMeta instance.
     *
     * @param  \Arcanedev\SeoHelper\Contracts\SeoMeta  $seoMeta
     *
     * @return self
     */
    public function setSeoMeta(Contracts\SeoMeta $seoMeta)
    {
        $this->seoMeta = $seoMeta;

        return $this;
    }

    /**
     * Get SeoOpenGraph instance.
     *
     * @return \Arcanedev\SeoHelper\Contracts\SeoOpenGraph
     */
    public function openGraph()
    {
        return $this->seoOpenGraph;
    }

    /**
     * Get SeoOpenGraph instance (alias).
     *
     * @see    \Arcanedev\SeoHelper\SeoHelper::openGraph()
     *
     * @return \Arcanedev\SeoHelper\Contracts\SeoOpenGraph
     */
    public function og()
    {
        return $this->openGraph();
    }

    /**
     * Get SeoOpenGraph instance.
     *
     * @param  \Arcanedev\SeoHelper\Contracts\SeoOpenGraph  $seoOpenGraph
     *
     * @return self
     */
    public function setSeoOpenGraph(Contracts\SeoOpenGraph $seoOpenGraph)
    {
        $this->seoOpenGraph = $seoOpenGraph;

        return $this;
    }

    /**
     * Get SeoTwitter instance.
     *
     * @return \Arcanedev\SeoHelper\Contracts\SeoTwitter
     */
    public function twitter()
    {
        return $this->seoTwitter;
    }

    /**
     * Set SeoTwitter instance.
     *
     * @param  \Arcanedev\SeoHelper\Contracts\SeoTwitter  $seoTwitter
     *
     * @return self
     */
    public function setSeoTwitter(Contracts\SeoTwitter $seoTwitter)
    {
        $this->seoTwitter = $seoTwitter;

        return $this;
    }

    /**
     * Set title.
     *
     * @param  string       $title
     * @param  string|null  $siteName
     * @param  string|null  $separator
     *
     * @return self
     */
    public function setTitle($title, $siteName = null, $separator = null)
    {
        $this->meta()->setTitle($title, $siteName, $separator);
        $this->openGraph()->setTitle($title);
        $this->openGraph()->setSiteName($siteName);
        $this->twitter()->setTitle($title);

        return $this;
    }

    /**
     * Set description.
     *
     * @param  string  $description
     *
     * @return \Arcanedev\SeoHelper\Contracts\SeoHelper
     */
    public function setDescription($description)
    {
        $this->meta()->setDescription($description);
        $this->openGraph()->setDescription($description);
        $this->twitter()->setDescription($description);

        return $this;
    }

    /**
     * Set keywords.
     *
     * @param  array|string  $keywords
     *
     * @return self
     */
    public function setKeywords($keywords)
    {
        $this->meta()->setKeywords($keywords);

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render all seo tags.
     *
     * @return string
     */
    public function render()
    {
        return implode(PHP_EOL, array_filter([
            $this->meta()->render(),
            $this->openGraph()->render(),
            $this->twitter()->render(),
        ]));
    }

    /**
     * Render the tag.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Enable the OpenGraph.
     *
     * @return self
     */
    public function enableOpenGraph()
    {
        $this->openGraph()->enable();

        return $this;
    }

    /**
     * Disable the OpenGraph.
     *
     * @return self
     */
    public function disableOpenGraph()
    {
        $this->openGraph()->disable();

        return $this;
    }

    /**
     * Enable the Twitter Card.
     *
     * @return self
     */
    public function enableTwitter()
    {
        $this->twitter()->enable();

        return $this;
    }

    /**
     * Disable the Twitter Card.
     *
     * @return self
     */
    public function disableTwitter()
    {
        $this->twitter()->disable();

        return $this;
    }
}
