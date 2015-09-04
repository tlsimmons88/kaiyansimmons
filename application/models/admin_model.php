<?php
class Admin_model extends CI_Model
{
	var $images_path;
	var $images_path_url;

	public function __construct()
	{
		parent::__construct();
		$this->images_path = realpath(APPPATH . '../webroot/media/photos/');
		$this->images_path_url = base_url('/media/photos/');
	}

	/*
	 * Add media information to database to then be used by a get method to populate the gallery
	 * @param 1 - $type_id - int - ID that matches to the types in the database
	 * @param 2 - $file_location - string - Location of where media file is stored, file name is included in path
	 * @param 3 - $thumb_location - string - Location of where media file thumb is stored, file name is included in path
	 * @param 4 - $tags - string - comma seperated list of tags that will be used to search or filter on
	 * @param 5 - $file_description - string - Description of the file, used for the caption for the gallery
	 * @param 6 - $date_taken - string - Date the image was taken
	 * @param 7 - $file_name - string - Name of file without path
	 */
	public function add_media($type_id, $file_location, $thumb_location, $tags, $file_description, $date_taken, $file_name)
	{
		try
		{
			//Convrt date format to make database happy
			$date_taken = date("Y-m-d", strtotime($date_taken));
			$sql = "INSERT INTO `kaiyansimmonsFMADB`.`media` (`type_id`, `file_location`, `thumb_location`, `tags`, `file_description`, `date_taken`, `date_uploaded`, `file_name`) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
			return $this->db->query($sql, array($type_id, $file_location, $thumb_location, $tags, $file_description, $date_taken, date("Y-m-d"), $file_name));
		}
		catch (Exception $ex)
		{
			throw $ex;
		}
	}

	/*
	 * Creates a thumbnail of the image passed in.  Image must already be uploaded to hosting server.  This uses the ImageMagick Lib
	 * @param 1 - $source_image_path - string - location to image to make a thumbnail of
	 * @param 2 - $date_taken - sting - date the image was taken.  This date is used to create the file path of where the thumbnail will be
	 * returns - bool - True it worked, false or exception it failed
	 */
	public function create_image_thumbnail($source_image_path, $date_taken)
	{
		$date_parts = explode("/", $date_taken);
		$thumb_path = $this->images_path."/thumbnails/".$date_parts[2]."/".$date_parts[0]."/";;
		$result['result'] = false;
		$result['thumb_path'] = $thumb_path;

		if(!is_dir($thumb_path)) //create the folder if it's not already exists
		{
			mkdir($thumb_path, 0755, TRUE);
		}

		$config = array(
			'image_library' => 'ImageMagick',
			'library_path' => '/usr/bin/convert',
			'source_image' => $source_image_path,
			'new_image' => $thumb_path,
			'create_thumb' => true,
			'maintain_ration' => true,
			'width' => 150,
			'height' => 100
		);

		try
		{
			$this->load->library('image_lib', $config);
			$result['result'] = $this->image_lib->resize();
		}
		catch (Exception $ex)
		{
			throw $ex;
		}
		return $result;
	}

	/*
	 * Uploads the file given to the hosting server
	 * @param 1 - string - $file_name - Name of image file to be uploaded
	 * @param 2 - string - $date_taken - Date the image was taken.  This take is used to build the file patch where the image will be uploaded to
	 * return - array - Info abo9ut image that was uploaded, string - if errors will return error string message
	 */
	public function upload_image($file_name, $date_taken)
	{
		$date_parts = explode("/", $date_taken);

		$image_path = $this->images_path."/".$date_parts[2]."/".$date_parts[0]."/";

		if(!is_dir($image_path)) //create the folder if it's not already exists
		{
			mkdir($image_path, 0755, TRUE);
		}

		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $image_path,
			'max_size' => 10000
		);

		$this->load->library('upload', $config);
		$this->upload->do_upload('file_name');
		$image_data = $this->upload->data();
		$errors = $this->upload->display_errors();;

		if (strlen($errors) > 0)
		{
			return $errors;
		}
		else
		{
			return $image_data;
		}
	}

	/*
	 * Grabs the media data from the database
	 * @param 1 - $date_taken_from - string - the start of date range to select from
	 * @param 2 - $date_taken_to - string - the end of date range to select from
	 //* @param 3 - $tags - string - the tag to search for within the given date range
	 * return = array - Media information matching search params
	*/
	public function get_media_by_date($date_taken_from, $date_taken_to)
	{
		try
		{
			$media = array();

			//Build the query
			$sql = "SELECT * FROM kaiyansimmonsFMADB.media ";
			$where = "";
			$and = "";

			if(strlen($date_taken_to) > 0 && strlen($date_taken_from) > 0)
			{
				//Convrt date format to make database happy
				//If we do the covnert before checking for length it will auto put in the starting dates for mysql which will give bad data back
				$date_taken_from = date("Y-m-d", strtotime($date_taken_from));
				$date_taken_to = date("Y-m-d", strtotime($date_taken_to));

				$where = "WHERE media.date_taken >= '".$date_taken_from."'
						  AND media.date_taken <= '".$date_taken_to."' ";
			}

			//If dates were given then append to query with AND
			/*if(strlen($tags) > 0 && strlen($date_taken_to) > 0 && strlen($date_taken_from) > 0)
			{
				$and = "AND FIND_IN_SET('".$tags."', media.tags)";
			}
			else if(strlen($tags) > 0)	//Otherwise start the WHERE of query
			{
				$where = "WHERE FIND_IN_SET(".$tags.", media.tags)";
			}*/

			$query = $this->db->query($sql.$where.$and.";");
			//var_dump($sql.$where.$and.";");
			$media = $query->result_array();

			return $media;
		}
		catch (Exception $ex)
		{
			throw $ex;
		}
	}
}
?>
