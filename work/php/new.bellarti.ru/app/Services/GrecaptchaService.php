<?

namespace App\Services;

class GrecaptchaService
{
	public static function check($token)
	{
		$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . env('GRECAPTCHA_PRIVATE_KEY') . '&response=' . $token;

		$response = json_decode(file_get_contents($url, true));
		return ($response && $response->success && $response->score >= 0.5)
			? true
			: false;
	}
}
