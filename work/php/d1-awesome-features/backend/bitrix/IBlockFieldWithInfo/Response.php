<?

namespace App\Bitrix\PropertyFields\IBlockFieldWithInfo;

class Response
{
	public static function returnFailed(?array $errors = null, ?array $headers = null): void
	{
		self::renderJSON([
			'success' => false,
			'errors' => $errors,
		], $headers);
	}

	public static function returnSuccess(?array $data = null, ?array $headers = null): void
	{
		self::renderJSON([
			'success' => true,
			'data' => $data,
		], $headers);
	}

	public static function badRequest(string $msg = 'Bad request', int $code = 404): void
	{
		header($code);
		die($msg);
	}

	public static function isAccept(): bool
	{
		$headers = getallheaders();
		if(!isset($headers['Accept'])){
			return false;
		}
		return $headers['Accept'] === 'application/json' ? true : false;
	}

	private static function renderJSON(array $value, ?array $headers = null, int $flags = JSON_UNESCAPED_UNICODE): void
	{
		if (!is_null($headers)) {
			foreach ($headers as $header) {
				header($header);
			}
		}
		header('Content-Type: application/json');
		echo json_encode($value, $flags);
		die;
	}
}
