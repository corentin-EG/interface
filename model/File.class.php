<?php

Class File {
	private $name,
			$type,
			$tmpName,
			$error,
			$size;

	private	$mimeList = array(
	            'jpeg' => 'image/jpeg',
	            'png' => 'image/png',
	            'gif' => 'image/gif',
	            'jpg' => 'image/jpeg',
	            'fbx' => 'text/plain',
	            'wav' => 'audio/x-wav',
	            'mp3' => 'audio/mpeg',
	            'mp4' => 'video/mp4'
	        );

	public function __construct(array $file) {

		foreach ($file as $key => $value)
		{
			$key = str_replace('_', '', $key);
			$method = 'set'.$key;
		}
			if (method_exists($this, $method)) $this->$method($value);

		if (!isset($this->error) || is_array($this->error)) {
	        throw new Exception('Invalid parameters.');
	    }

	    switch ($this->error) {
	        case UPLOAD_ERR_OK:
	            break;
	        case UPLOAD_ERR_NO_FILE:
	            throw new Exception('No file sent.');
	        case UPLOAD_ERR_INI_SIZE:
	        case UPLOAD_ERR_FORM_SIZE:
	            throw new Exception('Exceeded filesize limit.');
	            throw new Exception('Unknown errors.');
	    }

	    if ($this->size > 20000000) {
	        throw new Exception('Exceeded filesize limit.');
	    }

	    $finfo = new finfo(FILEINFO_MIME_TYPE);
	    if (false === $ext = array_search(
	        strtolower($finfo->file($this->tmpName)),
	        $this->mimeList,
	        true
	    )) {
	        throw new Exception("Invalid file format");
	    }


   
	}

	public function moveOnServer($version) {

		$version = $version == 0 ? 'source' : 'target';

		$loc = sprintf("../uploads/$version/%s", $this->name);
		$path = "http://www.games-brand.com/portal/uploads/$version/".$this->name;

		if (!move_uploaded_file($this->tmpName, $loc)) {
	        throw new Exception('Failed to move uploaded file.');
	        return FALSE;
	    }

		return $path;
	}

	public function name() { return $this->name; }

	public function type() { return $this->type; }

	public function tmpName() { return $this->tmpName; }

	public function error() { return $this->error; }

	public function size() { return $this->size; }

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

	public function setTmpName($tmpName)
	{
		$this->tmpName = $tmpName;
	}


	public function setError($error)
	{
		$this->error = $error;
	}


	public function setSize($size)
	{
		$this->size = $size;
	}

	public function info() {
		$info = array(
			'name' => $this->name,
			'type' => $this->type,
			'tmpName' => $this->tmpName,
			'error' => $this->error,
			'size' => $this->size
		);

		return $info;
	}



}