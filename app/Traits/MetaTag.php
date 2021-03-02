<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10.01.2017
 * Time: 16:03
 */

namespace App\Traits;

use \KodiCMS\Assets\Contracts\MetaInterface;
use \KodiCMS\Assets\Contracts\SocialMediaTagsInterface;

trait MetaTag
{

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->tags->implode(',');
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getMetaRobots()
    {
        return '...';
    }



}