CI 2.1 Display Class
====================

This is just a small class that I wrote that sits on top of CI's native view loader. I didn't like the idea of including a bunch of calls to the same site files over and over in each controller method, so I wrote a quick wrapper class to handle some of the mundane tasks that I do in loading views.

Methods & Parameters
--------------------

```$DEFAULT_JS_INCLUDES / $DEFAULT_CSS_INCLUDES``` - I've left a few of these in the file as an illustrative example, but these are where you would set any default js/css files that should be loaded with every page.  These can be overridden (see below) but this makes it easy to load your site-wide scripts and styles.

```set_prefix()``` - This method sets the prefix string, which is prepended to all of the page templates you load.  I mostly use this to separate the front end view files from the back end/admin view files by putting all of my admin views under the 'admin/' folder in views and setting the display prefix to '/admin' for those pages by calling ```$this->display->set_prefix('/admin');``` in the admin controller constructor.

```$wrapper``` - By default, the class loads the _html_top, _header, _footer, and _html_bottom files.  By setting $wrapper to FALSE it will skip the _header and _footer templates.  This ensures the page still has the proper HTML wrapper but won't include any site specific menus or footer information, which is useful for loading widgets or other iframe templates.

```view_data()``` - This method allows for setting view data within controllers by passing an array.  If the second parameter is set to true, it will override any values already set, such as the default js/css arrays. This allows for easily sending multiple values to your view throughout your controller methods rather than having to assemble it all at once, e.g.:

```
public function some_method() {
	// Initial variables
	$this->display->view_data(array(
		'my_var' => 'my_val',
		'big_int' => 123456789098,
	));
	
	// Do something else
	
	$user = $this->db->select('*')->from('user')->where('id', 1)->get()->row_array();
	
	// Only set if user exists
	if ($user) {
		$this->display->view_data(array('user' => $user));
	}
	
	...
}
```

TODO
----

* There is currently no way to return the templates once rendered.
* Meta tags have to be hard coded in the _html_top template.