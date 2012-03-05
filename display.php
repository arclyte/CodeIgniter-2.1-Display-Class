<?php

/**
 * CodeIgniter 2.1 Display Class
 * 
 * This is an interface for CodeIgniter's view loader that allows for more easily
 * loading common includes and template files from within controllers.
 *
 * @author James Alday
 */
class Display
{
	const DEFAULT_PAGE_TITLE = "Default Title";
	
	private $CI;
	private $prefix = ''; // prefix for view directory for wrapper files (ie, 'admin/')
	private $view_data; // data to pass along to templates

	public $wrapper = TRUE; // whether to display header and footer
	
	// JS loaded with any template that uses load_pages
	protected $DEFAULT_JS_INCLUDES = array(
		'/js/modernizer.js',
		'/js/jquery/jquery-1.7.1.min.js',
		'http://connect.facebook.net/en_US/all.js',
	);
	
	// CSS loaded with any template that uses load_pages
	protected $DEFAULT_CSS_INCLUDES = array(
		'/css/default.css',
	);
	
	/**
	 * Load view pages, passing default values and wrapper templates
	 * 
	 * @param string $name Url/Name of the template file(s) to load
	 * 
	 */
	public function load_pages($name) {
		$this->CI =& get_instance();
		
		// Always make sure we have a title set
		if (!isset($this->view_data['title'])) $this->view_data['title'] = self::DEFAULT_PAGE_TITLE;
		
		// CSS Includes
		if (isset($this->view_data['css'])) {
			$this->view_data['css'] = array_unique(array_merge($this->DEFAULT_CSS_INCLUDES, (array) $this->view_data['css']));
		} else {
			$this->view_data['css'] = $this->DEFAULT_CSS_INCLUDES;
		}

		// Javascript Includes
		if (isset($this->view_data['js'])) {
			$this->view_data['js'] = array_unique(array_merge($this->DEFAULT_JS_INCLUDES, (array) $this->view_data['js']));
		} else {
			$this->view_data['js'] = $this->DEFAULT_JS_INCLUDES;
		}
		
		// Top and header templates
		$this->CI->load->view($this->prefix . 'layout/_html_top.php', $this->view_data);
		
		if ($this->wrapper) {
			$this->CI->load->view($this->prefix . 'layout/_header.php', $this->view_data);
		}

		// Content templates loaded here
		if (is_array($name)) {
			// Load an array of template files
			foreach ($name as $template) {
				
				$this->CI->load->view($this->prefix . $template, $this->view_data);
				
			}
		} else {
			// Default to loading the one template file
			$this->CI->load->view($this->prefix . $name, $this->view_data);
		}

		// Footer template
		if ($this->wrapper) {
			$this->CI->load->view($this->prefix . 'layout/_footer.php');
		}
	}
	
	/**
	 * Set a prefix to all template paths
	 * 
	 * @param string $value 
	 */
	public function set_prefix($value) {
		$this->prefix = $value;
	}
	
	/**
	 * Use in controller to set data to send to view templates
	 * 
	 * Usage: $this->display->view_data(array('var1' => 'val1', 'var2' => 'val2'));
	 * 
	 * @param array $data
	 * @param bool $override
	 * @return void 
	 */
	public function view_data($data, $override = FALSE) {
		if (is_array($data)) {
			foreach ($data as $opt => $val) {
				if (!isset($this->view_data[$opt]) || $override) {
					$this->view_data[$opt] = $val;
				}
			}
		}
	}
}

?>