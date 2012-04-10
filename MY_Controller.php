<?php

/**
 * CodeIgniter 2.1 Display Controller
 *
 * This controller is an interface for CodeIgniter's view loader that
 * allows for more easily loading common includes and template files.
 *
 * @author jalday
 */
class MY_Controller extends CI_Controller
{
	const DEFAULT_PAGE_TITLE = "Default Title";
	
	public $project;
	
	private $prefix = '';
	private $view_data = array(); // data to pass along to templates
	private $wrapper = TRUE; // whether to display header and footer
	
	public function __construct() {
		parent::__construct();
	}
		
	/**
	 * Load view pages, passing default values and wrapper templates
	 * 
	 * @param string $name Url/Name of the template file(s) to load
	 * 
	 */
	public function load_pages($name, $no_wrapper = FALSE) {
		// Always make sure we have a title set
		if (!isset($this->view_data['title'])) $this->view_data['title'] = self::DEFAULT_PAGE_TITLE;
		
		// Top and header templates
		$this->load->view($this->prefix . 'layout/_html_top.php', $this->view_data);
		
		if ($this->wrapper) {
			$this->load->view($this->prefix . 'layout/_header.php', $this->view_data);
		}

		// Content templates loaded here
		if (is_array($name)) {
			// Load an array of template files
			foreach ($name as $template) {
				$this->load->view($this->prefix . $template, $this->view_data);
			}
		} else {
			// Default to loading the one template file
			$this->load->view($this->prefix . $name, $this->view_data);
		}

		// Footer template
		if (!$no_wrapper) {
			$this->load->view($this->prefix . 'layout/_footer.php');
		}
	}
	
	/**
	 * Set whether to display header/footer files on view templates
	 * 
	 * @param bool $value 
	 */
	public function set_wrapper(bool $value) {
		$this->wrapper = $value;
	}
	
	/**
	 * Use for setting template prefix path
	 * 
	 * @param type $value 
	 */
	public function set_prefix($value) {
		$this->prefix = $value;
	}
	
	/**
	 * Set variables that will be passed to view templates
	 * 
	 * @param type $data
	 * @param type $override
	 * @return boolean 
	 */
	public function view_data($data, $override = FALSE) {
		if (is_array($data)) {
			foreach ($data as $opt => $val) {
				if ($override || !isset($this->view_data[$opt])) {
					$this->view_data[$opt] = $val;
				} elseif ($opt == 'css' || $opt == 'js' || $opt == 'meta') {
					array_push($this->view_data[$opt], $val);
				}
			}
		}
		
		return TRUE;
	}
}

class Public_Controller extends MY_Controller
{
	function __construct() {
		parent::__construct();
	}
}

class Admin_Controller extends MY_Controller
{
	function __construct() {
		parent::__construct();
		
		$this->set_prefix('admin/');
	}
}
?>
