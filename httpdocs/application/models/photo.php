<?php
class Photo extends CI_model {
    
    var $path;
    var $filename;
    var $exif;
    var $label;
    var $age;
    
    var $thumbnail_url;
    var $url;
    var $fullsize_url;
    
    function __construct() {
        parent::__construct();
        $this->load->library('image_lib');
    }
    
    function load($filename) {
        $this->filename = $filename;
        $this->path = $this->config->config['photo_directory'] . '/' . $filename;
        $this->fullsize_url = $this->config->config['photo_directory_root_url'] . '/' . $filename;
        $this->load_exif_data();
        $this->resize_for_web();
        //$this->create_retina_image();
        $this->create_thumbnail();
        $this->set_label();
        $this->calculate_age();
    }
    
    private function calculate_age() {
        $age = "";
        $dob = date_create($this->config->config['dob']);
        $photo_date = date_create($this->exif['date_time']);
        $diff = date_diff($dob, $photo_date);

        // Less than zero add a minus
        if($diff->invert) {
            $age .= 'minus ';
        }
        if($diff->y > 0) {
            $age .= $diff->format('%y year');
            if($diff->y != 1) {
                $age .= "s";
            }
        }
        if($diff->m > 0) {
            if($diff->y > 1) {
                $age .= ", ";
            }
            $age .= $diff->format('%m month');
            if($diff->m != 1) {
                $age .= "s";
            }
            $age .= " and ";
        }
        // If minus, add a day
        if($diff->invert) {
            ++$diff->d;
        }
        $age .= $diff->format('%d day');
        if($diff->d != 1) {
            $age .= 's';
        }
        $this->age = $age;
    }
    
    private function set_label() {
        $label = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->filename);
        // Remove trailing number
        do {
            $n = substr($label, -1);
            if(is_numeric($n)) {
                $label = substr($label, 0, -1);
            }
        }
        while(is_numeric($n));
        substr($label,0,-1);
        $this->label = $label;
    }
    
    private function resize_for_web() {
        $this->url = $this->resize($this->filename, $this->config->config['photo_height']);
    }
    
    private function create_retina_image() {
        $this->url = $this->resize($this->filename, $this->config->config['photo_height'], true);
    }
    
    private function create_thumbnail() {
        $this->thumbnail_url = $this->resize($this->filename, $this->config->config['photo_thumbnail_height']);
    }
    
    private function resize($file, $height, $retina = false) {
        $photo_dir = $this->config->config['photo_directory'] . '/' . $height;
        if($retina) {
            $file_array = explode(".", $file);
            $target_file_name = $file_array[0] . '@2x' . '.' . $file_array[1];
        } else {
            $target_file_name = $file;
        }
        $target_file = $photo_dir . '/' . $target_file_name;
        
        if(!file_exists($photo_dir)) {
            mkdir($photo_dir);
        }
        if(!file_exists($target_file)) {
            $config['image_library'] = 'gd2';
            $config['thumb_marker'] = '';
            $config['source_image'] = $this->config->config['photo_directory'] . '/' . $file;
            $config['create_thumb'] = TRUE;
            $config['new_image'] = $target_file;
            $config['maintain_ratio'] = TRUE;
            $config['width']	= -1;
            if($retina == true) {
                $config['height'] = $height * 2;
            } else {
                $config['height'] = $height;
            }
            $this->load->library('image_lib');
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
        }
        return $this->config->config['photo_directory_root_url'] . '/' . $height . '/' . $file;
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