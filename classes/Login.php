<?php
require_once '../config.php';

class Login extends DBConnection
{
    private $settings;

    public function __construct()
    {
        global $_settings;
        $this->settings = $_settings;

        parent::__construct();
        ini_set('display_error', 1);
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    public function index()
    {
        echo "<h1>Access Denied</h1> <a href='" . base_url . "'>Go Back.</a>";
    }

    // Admin Login
    public function login()
    {
        extract($_POST);

        $qry = $this->conn->query("SELECT * FROM users WHERE username = '$username' AND password = md5('$password') AND type = 1");
        if ($qry->num_rows > 0) {
            foreach ($qry->fetch_array() as $k => $v) {
                if (!is_numeric($k) && $k != 'password') {
                    $this->settings->set_userdata($k, $v);
                }
            }
            $this->settings->set_userdata('login_type', 1);
            return json_encode(array('status' => 'success', 'redirect' => '/admin/index.php')); // Redirect to Admin Panel
        } else {
            return json_encode(array('status' => 'incorrect', 'message' => 'Invalid admin credentials.'));
        }
    }


    function login_user()
    {
        extract($_POST);
        $qry = $this->conn->query("SELECT * FROM users WHERE username = '$username' AND password = md5('$password') AND type = 0");

        if ($qry->num_rows > 0) {
            $user = $qry->fetch_array();

            if (!empty($user['preference'])) {

                $resp['status'] = 'success';
                $resp['redirect'] = '/index.php';
                $resp['preferences_set'] = true;
            } else {

                $resp['status'] = 'success';
                $resp['redirect'] = '/?page=edit_account';
                $resp['preferences_set'] = false;
            }

            foreach ($user as $k => $v) {
                if (!is_numeric($k) && $k != 'password') {
                    $this->settings->set_userdata($k, $v);
                }
            }

            $this->settings->set_userdata('login_type', 0);
        } else {
            $resp['status'] = 'incorrect';
        }

        if ($this->conn->error) {
            $resp['status'] = 'failed';
            $resp['_error'] = $this->conn->error;
        }

        return json_encode($resp);
    }



    public function logout()
    {
        if ($this->settings->sess_des()) {
            redirect('admin/login.php');
        }
    }
}

$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();

switch ($action) {
    case 'login':
        echo $auth->login();
        break;
    case 'login_user':
        echo $auth->login_user();
        break;
    case 'logout':
        echo $auth->logout();
        break;
    default:
        echo $auth->index();
        break;
}
