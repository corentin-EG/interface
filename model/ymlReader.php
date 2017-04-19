<?php

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

require_once '../composer/vendor/autoload.php';

class YamlReader {

	private $path,
			$filename;

	public function __construct($path, $filename) {
			$this->path = $path;
			$this->filename = $filename;
	}

	public function parse() {
		if (is_writable($this->path.$this->filename)) {

			if (!$handle = fopen($this->path.$this->filename, 'r+')) {
				echo "Cannot open file ($filename)";
				exit;
			}

			$lines = file($this->path.$this->filename);

			foreach ($lines as $line => $str) {
				if (substr($str, 0, 3) == '---') {
					$lines[$line] = '#'.$str;
				}
			}

			rewind($handle);
			fwrite($handle, implode('', $lines));
			fclose($handle);

		} else {
			echo "The file $filename is not writable";
			exit;
		}

		try {
			$output = Yaml::parse(file_get_contents('../uploads/GoldAchievement.asset'));

		} catch(ParseException $e) {
			printf("Erreur lors du parsing : %s", $e->getMessage());
		}
		return $output;
	}

	public function dump() {
		if (is_writable($this->path.$this->filename)) {

			if (!$handle = fopen($this->path.$this->filename, 'r+')) {
				echo "Cannot open file ($filename)";
				exit;
			}

			$lines = file($this->path.$this->filename);

			foreach ($lines as $line => $str) {
				if (substr($str, 0, 4) == '#---') {
					$lines[$line] = substr($str, 1);
				}
			}

			rewind($handle);
			fwrite($handle, implode('', $lines));
			fclose($handle);

		} else {
			echo "The file $filename is not writable";
			exit;
		}

		try {
			$output = Yaml::dump(file_get_contents('../uploads/GoldAchievement.asset'));
		} catch(ParseException $e) {
			printf("Erreur lors du parsing : %s", $e->getMessage());
		}
		return $output;
	}
}

$path = '../uploads/';
$filename = 'GoldAchievement.asset';
$yamlReader = new YamlReader($path, $filename);
$output = $yamlReader->dump();

echo '<pre>';
print_r($output);
echo '</pre>';

var_dump($output);