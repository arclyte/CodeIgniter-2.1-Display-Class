CI 2.1 Display Class
====================

This is just a small class that I wrote that extends CI's native controller to ease the use of views. I didn't like the idea of including a bunch of calls to the same site files over and over in each controller method, so I wrote a quick wrapper class to handle some of the mundane tasks that I do in loading views.

Methods & Parameters
--------------------

```set_prefix()``` - This method sets the prefix string, which is prepended to all of the page templates you load.  I mostly use this to separate the front end view files from the back end/admin view files by putting all of my admin views under the 'admin/' folder in views and setting the display prefix to '/admin' for those pages by calling ```$this->display->set_prefix('/admin');``` in the admin controller constructor.

```$wrapper``` - By default, the class loads the _html_top, _header, _footer, and _html_bottom files.  By setting $wrapper to FALSE it will skip the _header and _footer templates.  This ensures the page still has the proper HTML wrapper but won't include any site specific menus or footer information, which is useful for loading widgets or other iframe templates.

```view_data()``` - This method allows for setting view data within controllers by passing an array.  If the second parameter is set to true, it will override any values already set. This allows for easily sending multiple values to your view throughout your controller methods rather than having to assemble it all at once, e.g.:

```
public function some_method() {
	// Initial variables
	$this->view_data(array(
		'my_var' => 'my_val',
		'big_int' => 123456789098,
	));
	
	// Do something else
	
	$user = $this->db->select('*')->from('user')->where('id', 1)->get()->row_array();
	
	// Only set if user exists
	if ($user) {
		$this->view_data(array('user' => $user));
	}
	
	...
}
```

View Templates
---------

The ```views``` directory contains the layout template files that I commonly use as wrappers for my web pages.  They are obviously a bare minimum as presented and are built up and extended (or deleted altogether) as each project requires.  The most important file is the ```_html_top.php``` template.  If view_data arrays for 'js', 'css' and 'meta' have been set they are included within the head tag in this file.

Currently, I use a separate configuration file to contain my default css/js files that are included (or minified), but it should be easy enough to add any of those files directly into where it makes the most sense, whether at the Public/Admin_Controller level or further down within your app controllers or even methods if need be.


TODO
----

* There is currently no way to return the templates once rendered, so you will still need to manually ```load->view()``` and partials or email templates.