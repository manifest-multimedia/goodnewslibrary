<?php
/**
 * External Sources NextGen Class
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2021 ThemePunch
 * @since: 3.0.13
 **/

if(!defined('ABSPATH')) exit();

/**
 * NextGen
 *
 * show images from NextGen Albums and Galleries
 *
 * @package    socialstreams
 * @subpackage socialstreams/nextgen
 * @author     ThemePunch <info@themepunch.com>
 */
class Essential_Grid_Nextgen
{
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.0
	 */
	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array $stream Stream Data Array
	 */
	private $stream;

	public function __construct()
	{

	}

	/**
	 * Prepare list of Albums options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_album_list($current_album)
	{
		global $nggdb; //nextgen basic class

		// Galleries in Albums
		$albums = $nggdb->find_all_album();

		// Build <option>s for <select>
		$return = array();
		foreach ($albums as $album) {
			$album_details = $nggdb->find_album($album->id);
			$return[] = '<option value="' . $album_details->id . '" ' . selected($album_details->id, $current_album, false) . '>' . $album_details->name . '</option> ';
		}

		return $return;
	}

	/**
	 * Prepare list of Albums options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_gallery_list($current_gallery)
	{
		global $nggdb; //nextgen basic class

		// Galleries
		$gallerys = $nggdb->find_all_galleries();

		// Build <option>s for <select>
		$return = array();
		foreach ($gallerys as $gallery) {
			$return[] = '<option value="' . $gallery->gid . '" ' . selected($gallery->gid, $current_gallery, false) . '>' . $gallery->title . '</option> ';
		}

		return $return;
	}

	/**
	 * Prepare list of Tags options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_tag_list($current_tags)
	{
		global $nggdb; //nextgen basic class

		// Tags
		$tags = nggTags::find_all_tags();

		// Build <option>s for <select>
		$return = array();
		$current_tags = explode(",", $current_tags);
		foreach ($tags as $tag) {
			$selected = in_array($tag->term_id, $current_tags) ? 'selected' : '';
			$return[] = '<option value="' . $tag->term_id . '" ' . $selected . '>' . $tag->name . '</option> ';
		}

		return $return;
	}

	/**
	 * Prepare list of Albums options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_album_images($album_id)
	{
		global $nggdb; //nextgen basic class

		$galleries = $nggdb->find_album($album_id);
		$return = $this->get_gallery_images($galleries->gallery_ids);

		return $return;
	}

	/**
	 * Prepare list of Albums options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_tags_images($tags)
	{
		global $nggdb; //nextgen basic class

		$tags = explode(",", $tags);
		$picids = get_objects_in_term($tags, 'ngg_tag');
		$mapper = C_Image_Mapper::get_instance();
		$images = array();
		foreach ($picids as $image_id) {
			$images[] = $mapper->find($image_id);
		}

		foreach ($images as $image) {
			$image = nggdb::find_image($image->pid);
			$image_url = @array(
				'thumb' => array($image->thumbnailURL),
				'original' => array($image->imageURL),
			);
			$stream['custom-image-url'] = $image_url;

			$stream['custom-type'] = 'image';
			$stream['post-link'] = $image->imageURL;
			$stream['title'] = $image->alttext;
			$stream['content'] = $image->description;
			$stream['date'] = date_i18n(get_option('date_format'), strtotime($image->imagedate));
			$stream['date_modified'] = date_i18n(get_option('date_format'), strtotime($image->imagedate));
			$this->stream[] = $stream;
		}

		return $this->stream;
	}

	public function get_gallery_images($gallery_ids)
	{
		global $nggdb;
		$counter = 0;

		foreach ($gallery_ids as $gallery_id) {

			if (!is_numeric($gallery_id) && $counter < 25) {
				$counter++;
				$galleries_inside = $nggdb->find_album(preg_replace("/[^0-9]/", "", $gallery_id));
				$return = $this->get_gallery_images($galleries_inside->gallery_ids);
			} else {
				$this->nextgen_output_array($gallery_id);
			}
		}
		return $this->stream;
	}

	public function nextgen_output_array($gallery_id)
	{
		$images = nggdb::get_gallery($gallery_id);
		foreach ($images as $image) {
			if ($image->hidden) continue;
			$image_url = @array(
				'thumb' => array($image->thumbnailURL),
				'original' => array($image->imageURL),
			);
			$stream['custom-image-url'] = $image_url;

			$stream['custom-type'] = 'image';
			$stream['post-link'] = $image->imageURL;
			$stream['title'] = $image->alttext;
			$stream['content'] = $image->description;
			$stream['date'] = date_i18n(get_option('date_format'), strtotime($image->imagedate));
			$stream['date_modified'] = date_i18n(get_option('date_format'), strtotime($image->imagedate));
			$this->stream[] = $stream;
		}
	}

}
