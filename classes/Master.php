<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../config.php');
class Master extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}

	function save_package()
	{
		extract($_POST);
		$data = "";

		// Build the data string for insert or update
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}

		if (isset($_POST['description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `description`='" . addslashes(htmlentities($description)) . "' ";
		}

		// Insert or update the package record
		if (empty($id)) {
			$sql = "INSERT INTO `packages` set {$data} ";
			$save = $this->conn->query($sql);
			$id = $this->conn->insert_id;
		} else {
			$sql = "UPDATE `packages` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}

		// Handle file upload (image and video)
		if ($save) {

			// Handle image upload
			if (isset($_FILES['img']) && count($_FILES['img']['tmp_name']) > 0) {
				// Create a directory for images if it doesn't exist
				if (!is_dir(base_app . 'uploads/package_' . $id)) {
					mkdir(base_app . 'uploads/package_' . $id);
				}
				$upload_path = 'uploads/package_' . $id;
				$this->conn->query("UPDATE `packages` set `upload_path`='{$upload_path}' where id = '{$id}' ");
				foreach ($_FILES['img']['tmp_name'] as $k => $v) {
					move_uploaded_file($_FILES['img']['tmp_name'][$k], base_app . $upload_path . '/' . $_FILES['img']['name'][$k]);
				}
			}

			// Handle video upload
			if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {

				// Define video upload directory
				$video_path = 'uploads/video_' . $id . '/';

				// Create the video directory if it doesn't exist
				if (!is_dir(base_app . $video_path)) {
					mkdir(base_app . $video_path, 0777, true);
				}

				// Store the directory path in the database
				$video_directory = 'uploads/video_' . $id;
				$this->conn->query("UPDATE `packages` set `upload_path_video`='{$video_directory}' where id = '{$id}' ");

				// Define the video filename
				$video_filename = time() . '_' . $_FILES['video']['name'];
				$video_full_path = $video_path . $video_filename;

				// Move the uploaded video to the specified directory
				if (move_uploaded_file($_FILES['video']['tmp_name'], base_app . $video_full_path)) {
					// Optionally, you can store the video filename in the database for reference
					// $this->conn->query("UPDATE `packages` set `video_filename`='{$video_filename}' where id = '{$id}' ");
				}
			}

			// Return success response
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Package successfully saved.");
		} else {
			// Return failure response if the SQL query failed
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		// Return the response as JSON
		return json_encode($resp);
	}


	function delete_p_img()
	{
		extract($_POST);
		if (is_file($path)) {
			if (unlink($path)) {
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = 'unlink file failed.';
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'unlink file failed. File do not exist.';
		}
		return json_encode($resp);
	}


	function delete_p_video()
	{
		// Extract the POST parameters
		extract($_POST);

		// Prepare the full path
		$fullPath = $path;
		if (strpos($path, base_app) !== 0) {
			$fullPath = base_app . $path;
		}

		// Debug info
		error_log("Attempting to delete video at: " . $fullPath);

		// Check if the video file exists
		if (is_file($fullPath)) {
			// Attempt to delete the video file
			if (unlink($fullPath)) {
				// Return success response
				$resp['status'] = 'success';
			} else {
				// Return failure response if the file could not be deleted
				$resp['status'] = 'failed';
				$resp['message'] = 'Could not delete file. Check permissions.';
				$resp['error'] = error_get_last();
			}
		} else {
			// Return failure response if the file does not exist
			$resp['status'] = 'failed';
			$resp['message'] = 'File does not exist at path: ' . $fullPath;
		}

		// Return the JSON response
		return json_encode($resp);
	}

	function delete_package()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `packages` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			if (is_dir(base_app . 'uploads/package_' . $id)) {
				$file = scandir(base_app . 'uploads/package_' . $id);
				foreach ($file as $img) {
					if (in_array($img, array('..', '.')))
						continue;
					unlink(base_app . 'uploads/package_' . $id . '/' . $img);
				}
				rmdir(base_app . 'uploads/package_' . $id);
			}
			$this->settings->set_flashdata('success', "Location Details successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function book_tour()
	{
		extract($_POST);
		$data = " user_id = '" . $this->settings->userdata('id') . "' ";
		foreach ($_POST as $k => $v) {
			$data .= ", `{$k}` = '{$v}' ";
		}
		$save = $this->conn->query("INSERT INTO `book_list` set $data");
		if ($save) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function update_book_status()
	{
		extract($_POST);
		$update = $this->conn->query("UPDATE `book_list` set `status` = '{$status}' where id ='{$id}' ");
		if ($update) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Book successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function register()
	{
		extract($_POST);
		$data = "";
		$_POST['password'] = md5($password);
		foreach ($_POST as $k => $v) {
			if (!empty($data)) $data .= ",";
			$data .= " `{$k}`='{$v}' ";
		}
		$check = $this->conn->query("SELECT * FROM `users` where username='{$username}' ")->num_rows;
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Username already taken.";
			return json_encode($resp);
			exit;
		}
		$save = $this->conn->query("INSERT INTO `users` set $data ");
		if ($save) {
			foreach ($_POST as $k => $v) {
				$this->settings->set_userdata($k, $v);
			}
			$this->settings->set_userdata('id', $this->conn->insert_id);
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function update_account()
	{
		extract($_POST);
		$data = "";
		if (!empty($password)) {
			$_POST['password'] = md5($password);
			if (md5($cpassword) != $this->settings->userdata('password')) {
				$resp['status'] = 'failed';
				$resp['msg'] = "Current Password is Incorrect";
				return json_encode($resp);
				exit;
			}
		}
		$check = $this->conn->query("SELECT * FROM `users`  where `username`='{$username}' and `id` != $id ")->num_rows;
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Username already taken.";
			return json_encode($resp);
			exit;
		}
		foreach ($_POST as $k => $v) {
			if ($k == 'cpassword' || ($k == 'password' && empty($v)))
				continue;
			if (!empty($data)) $data .= ",";
			$data .= " `{$k}`='{$v}' ";
		}
		$save = $this->conn->query("UPDATE `users` set $data where id = $id ");
		if ($save) {
			foreach ($_POST as $k => $v) {
				if ($k != 'cpassword')
					$this->settings->set_userdata($k, $v);
			}

			$this->settings->set_userdata('id', $this->conn->insert_id);
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function save_inquiry()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!empty($data)) $data .= ",";
			$data .= " `{$k}`='{$v}' ";
		}
		$save = $this->conn->query("INSERT INTO `inquiry` set $data");
		if ($save) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function rate_review()
	{
		extract($_POST);
		$review = addslashes(htmlentities($review));
		$user_id = $_SESSION['userdata']['id'] ?? 0;
		$date_created = date('Y-m-d H:i:s');
		if ($user_id == 0) {
			return json_encode(['status' => 'failed', 'error' => 'User not logged in.']);
		}
		$check = $this->conn->query("SELECT id FROM `rate_review` WHERE package_id = '$package_id' AND user_id = '$user_id'");
		if ($check->num_rows > 0) {
			$save = $this->conn->query("UPDATE `rate_review` SET rate='$rate', review='$review', date_created='$date_created' 
								  WHERE package_id='$package_id' AND user_id='$user_id'");
		} else {
			$save = $this->conn->query("INSERT INTO `rate_review` (`package_id`, `user_id`, `rate`, `review`, `date_created`) 
								  VALUES ('$package_id', '$user_id', '$rate', '$review', '$date_created')");
		}
		if ($save) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}

		return json_encode($resp);
	}
	function delete_inquiry()
	{
		$del = $this->conn->query("DELETE FROM `inquiry` where id='{$_POST['id']}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", "Inquiry Deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_review()
	{
		$del = $this->conn->query("DELETE FROM `rate_review` where id='{$_POST['id']}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", "Feedback Deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_booking()
	{
		$del = $this->conn->query("DELETE FROM `book_list` where id='{$_POST['id']}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", "Booking Deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function save_policy()
	{
		extract($_POST);
		$policy = addslashes(htmlentities($policy));
		$check = $this->conn->query("SELECT id FROM `system_info` WHERE meta_field = 'policy'");
		if ($check->num_rows > 0) {
			$save = $this->conn->query("UPDATE `system_info` SET meta_value = '$policy' WHERE meta_field = 'policy'");
		} else {
			$save = $this->conn->query("INSERT INTO `system_info` (meta_field, meta_value) VALUES ('policy', '$policy')");
		}
		if ($save) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', 'Policy successfully saved.');
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function delete_highlight()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `highlights` WHERE id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', 'Highlight successfully deleted.');
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function get_highlights($package_id)
	{
		$sql = "SELECT h.id, h.highlight, u.name, h.date_created 
				FROM `highlights` h 
				LEFT JOIN `users` u ON h.user_id = u.id
				WHERE h.package_id = '{$package_id}' ORDER BY h.date_created DESC";
		$result = $this->conn->query($sql);

		$highlights = [];
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$highlights[] = $row;
			}
		}

		return $highlights;
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_package':
		echo $Master->save_package();
		break;
	case 'delete_p_video':
		echo $Master->delete_p_video();
		break;
	case 'delete_package':
		echo $Master->delete_package();
		break;
	case 'save_highlight':
		echo $master->save_highlight();
		break;
	case 'delete_p_img':
		echo $Master->delete_p_img();
		break;
	case 'book_tour':
		echo $Master->book_tour();
		break;
	case 'update_book_status':
		echo $Master->update_book_status();
		break;
	case 'register':
		echo $Master->register();
		break;
	case 'update_account':
		echo $Master->update_account();
		break;
	case 'save_inquiry':
		echo $Master->save_inquiry();
		break;
	case 'rate_review':
		echo $Master->rate_review();
		break;

	case 'delete_inquiry':
		echo $Master->delete_inquiry();
		break;
	case 'delete_booking':
		echo $Master->delete_booking();
		break;
	case 'delete_highlight':
		echo $Master->delete_highlight();
		break;
	case 'save_policy':
		echo $Master->save_policy();
		break;
	case 'delete_review':
		echo $Master->delete_review();
		break;
	default:
		// echo $sysset->index();
		break;
}
