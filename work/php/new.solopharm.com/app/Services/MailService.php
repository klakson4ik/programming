<?php

namespace App\Services;

class MailService
{
	private static $nameFile;
	private static $typeFile;
	private static $boundary;

	public static function getBody($data, $title, $autoMessage = true): String
	{
		$body = '';
		foreach ($data as $item) {
			if (!$item) continue;
			$body .= '<p>' . $item . '</p>' . PHP_EOL;
		}

		if ($autoMessage) {
			$body = '<p>' . __('pages.mail.auto-message') . '</p>' . PHP_EOL
				. '<p>==============================================</p>'  . PHP_EOL
				. $body
				. '<p>==============================================</p>';
		}

		return '<html>' . PHP_EOL
			. '<head>' . PHP_EOL
			. '<title>' . $title . '</title>' . PHP_EOL
			. '<meta http-equiv="content-type" content="text/html; charset=UTF-8">'. PHP_EOL
			. '</head>' . PHP_EOL
			. '<body>' . PHP_EOL
			.  $body . PHP_EOL
			. '</body>' . PHP_EOL
			. '</html>' . PHP_EOL;
	}

	public static function getHeaders($email, $name, $file = false)
	{
		$headers = self::getHeadersContentType($file);
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= 'From: ' . $name . '<' . $email . '>' . "\r\n";
		$headers .= "Content-Language: en-US, ru-RU\r\n\r\n";
		return $headers;
	}

	public static function getMixedBody($message, $file)
	{

		//plain text
		$body = '--' . self::$boundary . "\r\n";
		$body .= "Content-Type: text/html; charset=UTF-8\r\n";
		$body .= "Content-Transfer-Encoding: base64\r\n\r\n";
		$body .= chunk_split(base64_encode($message)) . "\r\n";

		//attachment
		$body .= '--' . self::$boundary . "\r\n";
		$body .= "Content-Type: " . self::$typeFile . "; name=\"" . self::$nameFile . "\"\r\n";
		$body .= "Content-Disposition: attachment; filename=" . self::$nameFile . "\r\n";
		$body .= "Content-Transfer-Encoding: base64\r\n\r\n";
		$body .= $file . "\r\n\r\n"; // Attaching the encoded file with email
		$body .= '--' . self::$boundary . "--";
		return $body;
	}

	public static function getFile($file)
	{
		$tmp_name = $file['tmp_name']; // get the temporary file name of the file on the server
		self::$nameFile     = $file['name']; // get the name of the file
		$size     = $file['size']; // get size of the file for size validation
		self::$typeFile     = $file['type']; // get type of the file
		$error     = $file['error'];
		if ($error > 0) {
			return false;
		}
		$handle = fopen($tmp_name, "r"); // set the file handle only for reading the file
		$content = fread($handle, $size); // reading the file
		fclose($handle);
		return chunk_split(base64_encode($content));
	}

	private static function getHeadersContentType($file){
		if ($file) {
			self::$boundary = '--------------' . md5("random");
			return "Content-Type: multipart/mixed; boundary=\"" .self::$boundary  . "\"\r\n"; //Defining the Boundary
		} else {
			return "Content-type: text/html\r\n";
		}
	}
}
