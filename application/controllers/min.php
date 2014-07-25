<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Min extends CI_Controller {
	public function css()
	{
		$this->load->driver('minify');
		$css = $this->minify->combine_directory('assets/css/');
		$this->output->set_content_type('text/css')->set_output($css);
	}
	
	public function js()
	{
		$this->load->driver('minify');
		$js = $this->minify->combine_directory('assets/js/', array('ZeroClipboard.swf'));
		$this->output->set_content_type('application/javascript')->set_output($js);
				
	}
}