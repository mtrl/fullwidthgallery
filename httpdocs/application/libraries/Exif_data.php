<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Exif data
 *
 * Library for extracting exif data from photos
 *
 * @package		Exif_data
 * @author		Jonas Edemalm (http://www.retype.se)
 * @version		0.1
 * @based on 	http://www.quietless.com/kitchen/extract-exif-data-using-php-to-display-gps-tagged-images-in-google-maps/
 */
class Exif_data{

	function __construct(){ }
	
	
	/**
	 * Fetch longitude and latitude values in decimal format
	 *
	 * @param	string	(full local path to jpg image)
	 * @return	array
	 */
	public function get_gps_data($full_image_path){
	
		$raw_exif = exif_read_data($full_image_path, 0, true);
				
		    
	    if (isset($raw_exif['GPS']['GPSLatitude']) && isset($raw_exif['GPS']['GPSLongitude'])){ 
	       
			$lat = $raw_exif['GPS']['GPSLatitude']; 
		    $log = $raw_exif['GPS']['GPSLongitude'];
	       		
	       	// latitude values //
	       	$lat_degrees = $this->divide($lat[0]);
	       	$lat_minutes = $this->divide($lat[1]);
	       	$lat_seconds = $this->divide($lat[2]);
	       	$lat_hemi = $raw_exif['GPS']['GPSLatitudeRef'];
 
	       	// longitude values //
	       	$log_degrees = $this->divide($log[0]);
	       	$log_minutes = $this->divide($log[1]);
	       	$log_seconds = $this->divide($log[2]);
	       	$log_hemi = $raw_exif['GPS']['GPSLongitudeRef'];
	  		 
	       	$data["lat_decimal"] = $this->toDecimal($lat_degrees, $lat_minutes, $lat_seconds, $lat_hemi);
	       	$data["long_decimal"] = $this->toDecimal($log_degrees, $log_minutes, $log_seconds, $log_hemi);
	       		
	    }
	       
	    else{
		       
			$data["lat_decimal"] = "null";
		    $data["long_decimal"] = "null";
		       
	    }
	       
	    return $data;
	}
	
	
	/**
	 * Fetch different infos about image
	 *
	 * @param	string	(full local path to jpg image)
	 * @return	array
	 */
	public function get_exif_info($full_image_path){
		$raw_exif = exif_read_data($full_image_path, 0, true);
		if(!isset($raw_exif["EXIF"]["DateTimeOriginal"])) {
			$data["date_time"] = date('Y-m-d H:i:s', filemtime($full_image_path));
		} else {		
			@$data["make"] = $raw_exif["IFD0"]["Make"];
			@$data["model"] = $raw_exif["IFD0"]["Model"];
			$data["date_time"] = $raw_exif["EXIF"]["DateTimeOriginal"];
			@$data["exposure_time"] = $raw_exif["EXIF"]["ExposureTime"];	
			@$data["f_number"] = $raw_exif["EXIF"]["FNumber"];
			@$data["iso_speed"] = $raw_exif["EXIF"]["ISOSpeedRatings"];
			@$data["shutter_speed"] = $raw_exif["EXIF"]["ShutterSpeedValue"];
			
		}
	       
	    return $data;
	}
	
	/* Help functions */

	private function divide($a){
		// evaluate the string fraction and return a float
		$e = explode('/', $a);
		// prevent division by zero 
		if (!$e[0] || !$e[1]) {
			return 0;
		} else{
			return $e[0] / $e[1];
		}
	}
	
	private function toDecimal($deg, $min, $sec, $hemi){
    	$d = $deg + $min/60 + $sec/3600;
    	return ($hemi=='S' || $hemi=='W') ? $d*=-1 : $d;
    }
 
  
}

/* End of file Exif_data.php */
/* Location: ./application/libraries/Exif_data.php */