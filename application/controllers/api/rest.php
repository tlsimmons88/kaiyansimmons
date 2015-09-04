<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Rest extends REST_Controller
{
	public function upload_post()
	{
		$upload_data = array();
		$thumbnail_data = array();

		$this->load->model('Admin_model');

		$date_taken = isset($_POST['date_taken']) ? trim($_POST['date_taken']) : "";
		$file_description = isset($_POST['file_description']) ? trim($_POST['file_description']) : "";
		$file_name = isset($_POST['file_name']) ? trim($_POST['file_name']) : "";
		$file_type = isset($_POST['file_type']) ? trim($_POST['file_type']) : "";
		$tags = isset($_POST['tags']) ? strtolower(trim($_POST['tags'])) : "";

		if($date_taken == "")
		{
			//Curent Date
			$date_taken = date("m/d/Y");
		}
		if($file_name == "")
		{
			$message = array('status' => "ERROR", 'message' => "Please select a file.", 'Details' => "date_taken = ".$date_taken.", file_description = ".$file_description.", file_name = ".$file_name.", file_type = ".$file_type.", tags = ".$tags.", title = ".$title);
			return $this->response($message, 400);
		}
		if($file_type == "")
		{
			$message = array('status' => "ERROR", 'message' => "Unsupported file type.", 'Details' => "date_taken = ".$date_taken.", file_description = ".$file_description.", file_name = ".$file_name.", file_type = ".$file_type.", tags = ".$tags.", title = ".$title);
			return $this->response($message, 400);
		}

		switch($file_type)
		{
			case 'image/png':
			case 'image/gif':
			case 'image/jpeg':
			{
				//This value is to be stored in database later
				$type_id = 1;

				$upload_data = $this->Admin_model->upload_image($file_name, $date_taken);

				//If the Upload worked then create the thumb nail
				if(strlen($upload_data['file_name']) > 0)
				{
					$thumbnail_data = $this->Admin_model->create_image_thumbnail($upload_data['full_path'], $date_taken);

					//ImageMagic will return true if the image resize so we check for 'not' true and return an error message
					if($thumbnail_data['result'] !=  true)
					{
						$message = array('status' => "ERROR", 'message' => "File Upload worked but thumbnail creation failed.", 'Details' => "date_taken = ".$date_taken.", file_description = ".$file_description.", file_name = ".$file_name.", file_type = ".$file_type.", tags = ".$tags.", title = ".$title);
						return $this->response($message, 400);
					}
				}
				else  //If no file name given then the upload did not work
				{
					$message = array('status' => "ERROR", 'message' => "File Upload failed.", 'Details' => "date_taken = ".$date_taken.", file_description = ".$file_description.", file_name = ".$file_name.", file_type = ".$file_type.", tags = ".$tags.", title = ".$title);
					return $this->response($message, 500);
				}
				break;
			}
			default:
			{
				$message = array('status' => "ERROR", 'message' => "Unsupported file type.  Supported types:  jpg, gif, png", 'Details' => "date_taken = ".$date_taken.", file_description = ".$file_description.", file_name = ".$file_name.", file_type = ".$file_type.", tags = ".$tags.", title = ".$title);
				return $this->response($message, 400);
			}
		}

		try
		{
			//Example string that we want to start from the 38th place from:  /home/tlsimmons88/public_html/webroot/media/.....
			$file_location = substr($upload_data['full_path'], 38);
			$thumb_location = substr($thumbnail_data['thumb_path'], 38);

			//Format the thumb_location info with the path and the file name of the thumb
			$pos = strrpos($upload_data['file_name'], ".");
			$thumb_file_name = substr($upload_data['file_name'], 0, $pos) . '_thumb' . substr($upload_data['file_name'], $pos);
			$thumb_location .= $thumb_file_name;

			//Now insert info into database
			//There is no way to get thumbnail file name...CI lib just appends '_thub' to the end of the file name automatically
			//So we take the file path, file name nad append the thumb to get full info for database
			$result = $this->Admin_model->add_media($type_id, $file_location, $thumb_location, $tags, $file_description, $date_taken, $upload_data['file_name']);
		}
		catch(Exception $ex)
		{
			$message = array('status' => "ERROR", 'message' => "Failed to add media to database.  ".$ex->getMessage(), 'Details' => "date_taken = ".$date_taken.", file_description = ".$file_description.", file_name = ".$file_name.", file_type = ".$file_type.", tags = ".$tags.", title = ".$title);
			return $this->response($message, 500);
		}
		if($result == false)
		{
			$message = array('status' => "ERROR", 'message' => "Failed to add media to database.  Result came back false.", 'Details' => "date_taken = ".$date_taken.", file_description = ".$file_description.", file_name = ".$file_name.", file_type = ".$file_type.", tags = ".$tags.", title = ".$title);
			return $this->response($message, 500);
		}

		$message = array('status' => "OK", 'message' => "File Uploaded, thumbnail created and media info added to database.", 'Details' => "date_taken = ".$date_taken.", file_description = ".$file_description.", file_name = ".$file_name.", file_type = ".$file_type.", tags = ".$tags);
		return $this->response($message, 200); // 200 being the HTTP response code
	}

	public function media_by_date_get()
	{
		$this->load->model('Admin_model');
		$results = array();

		$date_taken_from = isset($_GET['from']) ? trim($_GET['from']) : "";
		$date_taken_to = isset($_GET['to']) ? trim($_GET['to']) : "";
		//$tags = isset($_GET['tags']) ? strtolower(trim($_GET['tags'])) : "";

		$results = $this->Admin_model->get_media_by_date($date_taken_from, $date_taken_to);
		$message = array('status' => "OK", 'message' => "Media found:  ".count($results),'data' => json_encode($results), 'details' => "from = ".$date_taken_from.", to = ".$date_taken_to);
		return $this->response($message, 200);

	}
}