<?php
/**
 * ING/PHPSDK/RESOURCES/Videos.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @package ING\PHPSDK\RESOURCES
 * @filesource
 */

namespace ING\PHPSDK\RESOURCES;

/**
 * Class Videos
 *
 * @package ING\PHPSDK\RESOURCES
 */
class Videos extends AbstractResources {
    /**
     * @var string
     */
    protected $playlists = '/<%=resource%>/<%=id%>/playlists';

    /**
     * @var string
     */
    protected $variants = '/<%=resource%>/<%=id%>/variants';

    /**
     * @var string
     */
    protected $withVariants = '/<%=resource%>?filter=variants';

    /**
     * @var string
     */
    protected $missingVariants = '/<%=resource%>?filter=missing_variants';

    /**
     * @var string
     */
    protected $resource = 'videos';

    /**
     * Return any playlists that contains the provided video.
     *
     * @param $id
     */
    public function getPlaylists($id) {

    }

    /**
     * Get all of the variants for the supplied video id.
     *
     * @param $id
     */
    public function getVariants($id) {

    }

    /**
     * Return a list of the videos for the current user and network that contain variants.
     *
     * @param $headers
     */
    public function getVideosWithVariants($headers)  {
    }

    /**
     * Return a list of the videos for the current user and network that are missing variants.
     *
     * @param $heades
     */
    public function getVideosMissingVariants($heades) {

    }
}