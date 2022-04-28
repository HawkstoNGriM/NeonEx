<?php
namespace DetectCMS\Systems;

class Textpattern extends \DetectCMS\DetectCMS {

	public $methods = array(
		"readme",
		"generator_header",
		"generator_meta",
		"published",
		"js",
	);

	public $home_html = "";
    public $home_headers = array();
	public $url = "";

        function __construct($home_html, $home_headers, $url) {
                $this->home_html = $home_html;
                $this->home_headers = $home_headers;
                $this->url = $url;
        }

	/**
	 * See if README.txt exists, and contains Textpattern title
	 * @return [boolean]
	 */
	public function readme() {

		if($data = $this->fetch($this->url."/README.txt")) {

			require_once(dirname(__FILE__)."/../Thirdparty/simple_html_dom.php");

			if($html = str_get_html($data)) {
				if (str_contains($html,"Textpattern")){
					return strpos($title->plaintext, "Textpattern CMS") !== FALSE;
				}

			}

		}

		return FALSE;

	}

	/**
	 * Check for Generator header
	 * @return [boolean]
	 */
	public function generator_header() {

		if(is_array($this->home_headers)) {

			foreach($this->home_headers as $line) {

				if(strpos($line, "generator") !== FALSE) {

					return strpos($line, "Textpattern CMS") !== FALSE;

				}

			}

		}

		return FALSE;

	}

	/**
	 * Check meta tags for generator
	 * @return [boolean]
	 */
	public function generator_meta() {

		if($this->home_html) {

			require_once(dirname(__FILE__)."/../Thirdparty/simple_html_dom.php");

			if($html = str_get_html($this->home_html)) {

				if($meta = $html->find("meta[name='generator']",0)) {

					return strpos($meta->content, "Textpattern CMS") !== FALSE;

				}

			}

		}

		return FALSE;

	}

	/** REMOVED THE button.css from Wordpress file, textpattern doesnt have this */
	
	/**
	 * Check for "Published with"
	 * @return [boolean]
	 */
	public function published() {

		if($this->home_html) {

			require_once(dirname(__FILE__)."/../Thirdparty/simple_html_dom.php");

			if($html = str_get_html($this->home_html)) {
				if(str_contains($html,"Published with")){
					if($meta = $html->find("a[href='https://textpattern.com/']",0)) {

						return strpos($meta->content, "Textpattern CMS") !== FALSE;

					}

				}
			}

		}

		return FALSE;

	}

	/**
	* Checks for /textpattern/textpattern.js  
	* admin-side "cookies required" warning
	* @return [boolean]
	*/
	public function js() {
		if($data = $this->fetch($this->url."/textpattern/textpattern.js")) {
			require_once(dirname(__FILE__)."/../Thirdparty/simple_html_dom.php");
			if($html = str_get_html($data)) {
				if(str_contains($html,"// ----------------------------------")){
					return TRUE;
				}
			}

		}
		return FALSE;
	}

}
