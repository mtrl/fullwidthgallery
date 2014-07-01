<?php
class Photo extends CI_model {
    
    var $path;
    var $filename;
    var $exif;
    
    var $thumbnail_url;
    
    function __construct() {
        parent::__construct();
        
        $this->load->library('image_lib');
    }
    
    function load($filename) {
        $this->filename = $filename;
        $this->path = $this->config->config['photo_directory'] . '/' . $filename;
        $this->load_exif_data();
        $this->url = $this->config->config['photo_directory_root_url'] . '/' . $filename;
        $this->create_thumbnail();
    }
    
    private function create_thumbnail() {
        if(!file_exists($this->config->config['photo_directory_thumbnails'] . '/' . $this->filename)) {
            $config['image_library'] = 'gd2';
            $config['thumb_marker'] = '';
            $config['source_image']	= $this->path;
            $config['create_thumb'] = TRUE;
            $config['new_image'] = $this->config->config['photo_directory_thumbnails'] . '/' . $this->filename;
            $config['maintain_ratio'] = TRUE;
            $config['width']	= -1;
            $config['height']	= $this->config->config['photo_thumbnail_height'];
            $this->load->library('image_lib');
            $this->image_lib->initialize($config);
            try {
                $this->image_lib->resize();
            } catch(Exception $ex) {
                echo $ex->message;
            }
        }
        $this->thumbnail_url = $this->config->config['photo_directory_thumbnails_root_url'] . '/' . $this->filename;
    }
    
    private function load_exif_data() {
        $this->load->library('Exif_data');
        try {
            foreach($this->exif_data->get_gps_data($this->path) as $key => $value) {
                $this->exif[$key] = $value;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        
        try {
            foreach($this->exif_data->get_exif_info($this->path) as $key => $value) {
                $this->exif[$key] = $value;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}