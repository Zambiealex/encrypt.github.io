<?php
class thumb {
	
	private $image,
			$type,
			$width,
			$height,
			$filename,
			$file_extension,
			$ffmpeg,
			$allow = array( '.webm', '.mp4', '.avi');
	
	public function __construct()
	{
			global $page;
			
			// MAKE THUMBS FROM VIDEOS
			$this->ffmpeg = $page->data->ffmpeg;	
	}
	
	//---Método de leer la imagen
	function load($name) {
		$ext = substr($name, strpos($name,'.'), strlen($name));
		if(in_array($ext, $this->allow) )
		{
				$this->filename = $name;
				$this->file_extension = $ext;
				return;
		}
		
		//---Tomar las dimensiones de la imagen
		$info = getimagesize($name);
		
		$this->width = $info[0];
		$this->height = $info[1];
		$this->type = $info[2];
		
		//---Dependiendo del tipo de imagen crear una nueva imagen
		switch($this->type){
			case IMAGETYPE_JPEG:
				$this->image = imagecreatefromjpeg($name);
			break;
			case IMAGETYPE_GIF:
				$this->image = imagecreatefromgif($name);
			break;
			case IMAGETYPE_PNG:
				$this->image = imagecreatefrompng($name);
			break;
		}
	}
	
		 
	public static function generate($path , $source, $any = '',$width = 120 , $height = 90)
	{
		$query = '';
		if(!empty($source) )
		{
			$query = NULL;
			$query = "<img src='{$path}' style='width:{$width}px;height:{$height}px;'" . $any . " />";
		}
		return $query;
	}
	
	//---Método de guardar la imagen
	function save($name, $source,  $quality = 100, $type = '.jpg', $prefix= '_thumb') {
		
		$image = NULL;
		
		if( !empty($this->filename) )
		{
				$dir = $this->filename;
				$newfile = str_replace($this->file_extension, '' , $dir);
				$newfile = $newfile . $prefix . $type;
				$result = $this->createMovieThumb($dir, $newfile, $size = '120x120');
				
				$source = $source . $prefix;
				
				$spname = substr($source, strrpos($newfile, '/') ) . $type;
		
				return (object) array('name' => $spname, 'patch' => $newfile);
		}
		
		//---Guardar la imagen en el tipo de archivo correcto
		switch($this->type){
			case IMAGETYPE_GIF:
				$image =	imagecreatefromgif($this->image);
			break;
			case IMAGETYPE_PNG:
				$image = 	imagecreatefrompng($this->image);
			break;
		}
		$dir = $name . $prefix .  $type;
	
		imagejpeg($this->image, $dir, $quality);
		
		$source = $source . $prefix;
		$spname = substr($source, strrpos($name, '/') ) . $type;
		
		return (object) array('name' => $spname, 'patch' => $dir);
	}
	 
	
	//---Método de mostrar la imagen sin salvarla
	function render() {
		
		//---Mostrar la imagen dependiendo del tipo de archivo
		switch($this->type){
			case IMAGETYPE_JPEG:
				imagejpeg($this->image);
			break;
			case IMAGETYPE_GIF:
				imagegif($this->image);
			break;
			case IMAGETYPE_PNG:
				imagepng($this->image);
			break;
		}
	}
	
	//---Método de redimensionar la imagen sin deformarla
	function resize($value, $prop){
		
		if(!empty($this->filename))
		{
				return false;
		}
		//---Determinar la propiedad a redimensionar y la propiedad opuesta
		$prop_value = ($prop == 'width') ? $this->width : $this->height;
		$prop_versus = ($prop == 'width') ? $this->height : $this->width;
		
		//---Determinar el valor opuesto a la propiedad a redimensionar
		$pcent = $value / $prop_value;
		$value_versus = $prop_versus * $pcent;
		
		//---Crear la imagen dependiendo de la propiedad a variar
		$image = ($prop == 'width') ? imagecreatetruecolor($value, $value_versus) : imagecreatetruecolor($value_versus, $value);
		
		//---Hacer una copia de la imagen dependiendo de la propiedad a variar
		switch($prop){
			
			case 'width':
				imagecopyresampled($image, $this->image, 0, 0, 0, 0, $value, $value_versus, $this->width, $this->height);
			break;
			
			case 'height':
				imagecopyresampled($image, $this->image, 0, 0, 0, 0, $value_versus, $value, $this->width, $this->height);
			break;
			
		}
		
		//---Actualizar la imagen y sus dimensiones
		//$info = getimagesize($image);
		
		$this->width = imagesx($image);
		$this->height = imagesy($image);
		$this->image = $image;
		
	}
	
	
	//---Método de extraer una sección de la imagen sin deformarla
	function crop($cwidth, $cheight, $pos = 'center') {
		
		//---Dependiendo del tamaño deseado redimensionar primero la imagen a uno de los valores
		if($cwidth > $cheight){
			$this->resize($cwidth, 'width');
			}else{
			$this->resize($cheight, 'height');
		}
		
		//---Crear la imagen tomando la porción del centro de la imagen redimensionada con las dimensiones deseadas
		$image = imagecreatetruecolor($cwidth, $cheight);
		
		switch($pos){
			
			case 'center':
				imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
			break;
			
			case 'left':
				imagecopyresampled($image, $this->image, 0, 0, 0, abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
			break;
			
			case 'right':
				imagecopyresampled($image, $this->image, 0, 0, $this->width - $cwidth, abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
			break;
			
			case 'top':
				imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), 0, $cwidth, $cheight, $cwidth, $cheight);
			break;
			
			case 'bottom':
				imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), $this->height - $cheight, $cwidth, $cheight, $cwidth, $cheight);
			break;
			
		}
		
		$this->image = $image;
	}
	
	public function createMovieThumb($srcFile, $destFile = "test.jpg", $size = '100x100')
    {
        // Change the path according to your server.
        $ffmpeg_path = $this->ffmpeg;
		
        $cmd = sprintf('%s -i %s -an -ss 00:00:05 -r 1 -s %s -vframes 1 -y %s', 
            $ffmpeg_path, $srcFile, $size, $destFile);

        if (strtoupper(substr(PHP_OS, 0, 3) == 'WIN'))
            $cmd = str_replace('/', DS, $cmd);
        else
            $cmd = str_replace('\\', DS, $cmd);

        system($cmd);

        return $destFile;
    }
	
	public static function deleteDir($dirPath) {
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}
}
?>