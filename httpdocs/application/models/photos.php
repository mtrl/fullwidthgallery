<?php
class Photos extends CI_Model {
    
    var $photos;
    var $photos_by_month;
    
    function __construct() {
        parent::__construct();
    }
    
    function get_photos() {
        $this->load->helper('file');
        $this->load->model('photo');
                
        $dir = $this->config->config['photo_directory'];
        $photo_files = get_filenames($dir);
        foreach($photo_files as $photo_file) {
            $photo = new Photo();
            $photo->load($photo_file);
            $this->photos[] = $photo;
        }
        $this->sort_photos();
        //$this->remove_photos_without_date();
        $this-> group_by_month();
    }
    
    private function group_by_month() {
        $photos_by_month;
        foreach($this->photos as $photo) {
            // Get year and month of photo
            $year_and_month = date('Y-m\-\0\1',strtotime($photo->exif['date_time']));
            $photos_by_month[$year_and_month][] = $photo;
        }
        $this->photos_by_month = $photos_by_month;
    }
    
    private function sort_photos() {
        usort($this->photos, 'compare');
        // Remove duplicates
        $this->photos = array_map("unserialize", array_unique(array_map("serialize", $this->photos)));
    }
    
    private function remove_photos_without_date() {
        foreach($this->photos as $key => $photo) {
            if ($photo->exif['date_time'] == "") {
                unset($this->photos[$key]);
            }
        }
    }
    
}

// Sort by date ASC
function compare($a, $b) {
    return strtotime($b->exif['date_time']) - strtotime($a->exif['date_time']);
}