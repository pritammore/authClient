<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class UserController extends Controller
{
	protected $code;
    
    var $client_id = '5c794dedde008a0d680016d0';

    var $client_secret = 'scGohhtXmLjDoXCiOubDm8jXkIrQ4lLommGQvjAM';

    public function login()
    {
        $query = http_build_query([
	        'client_id' => $this->client_id,
	        'redirect_uri' => 'http://localhost:8080/callback',
	        'response_type' => 'code',
	        'scope' => '',
	    ]);

	    return redirect('http://localhost:8000/oauth/authorize?'.$query);
    }

    public function getToken(Request $request)
    {
    	$client = new Client(['http_errors' => false]);

    	$response = $client->post('http://localhost:8000/oauth/token', [
	        'form_params' => [
	            'grant_type' => 'authorization_code',
	            'client_id' => $this->client_id,
	            'client_secret' => $this->client_secret,
	            'redirect_uri' => 'http://localhost:8080/callback',
	            'code' => $request->code,
	        ],
	    ]);

	    $tokenResponse = json_decode((string) $response->getBody(), true);

	    session()->put('token', $tokenResponse, true);

	    // Check for access token present
	    if(isset($tokenResponse["error"])) {
	    	return redirect('/')->withWarning('Error: '. $tokenResponse["error"]);
	    }
	    
	    $this->code = $request->code;

	    $result = $this->user();

	    return redirect('dashboard');
    }

    public function logout(Request $request)
    {
        if ( ! session()->has('token')) {
	        return redirect('/')->withWarning('Something went wrong. Please try again.');
	    }

        // request to logout a user
    	$client = new Client();

	    // Access Token received then get the user details.
	    $userResponse = $client->get('http://localhost:8000/api/logout', [
	        'headers' => [
	            'Authorization' => 'Bearer ' . session()->get('token.access_token'),
	            'code'	=>	$this->code,
	        ],
	    ]);

	    $userResponse = json_decode($userResponse->getBody(), true);

	    $request->session()->flush();

	    return redirect('/')->withSuccess('Logged Out Successfully.');

    }

    public function user()
    {
    	if ( ! session()->has('token')) {
	        return redirect('/')->withWarning('Login required to view dashboard');
	    }

        $client = new Client();

	    // Access Token received then get the user details.
	    $userResponse = $client->get('http://localhost:8000/api/user', [
	        'headers' => [
	            'Authorization' => 'Bearer ' . session()->get('token.access_token'),
	            'code'	=>	$this->code,
	        ],
	    ]);
	    $userResponse = json_decode((string) $userResponse->getBody(), true);

	    return $userResponse;
    }

    public function validateEmail(Request $request)
    {
    	if ( ! session()->has('token')) {
	        return redirect('/')->withWarning('Login required to make this validation.');
	    }

	    $request->validate([
            'email' => 'required|string|email',
        ]);

	    $email_to_validate = $request->input('email');

        $client = new Client();

	    // Access Token received then get the user details.
	    $userResponse = $client->get('http://localhost:8000/api/user', [
	        'headers' => [
	            'Authorization' => 'Bearer ' . session()->get('token.access_token'),
	            'code'	=>	$this->code,
	        ],
	    ]);
	    $userResponse = json_decode($userResponse->getBody(), true);

	    if(isset($userResponse["error"])) {
	    	return redirect('/dashboard')->withWarning('Error: '. $tokenResponse["error"]);
	    }

	    if($userResponse['email'] == $email_to_validate) {
	    	return redirect('/dashboard')->withSuccess($email_to_validate. ' is valid email address of current user');	
	    }

	    return redirect('/dashboard')->withWarning($email_to_validate. ' is not a valid email address of current user');
    }

    public function dashboard() 
    {
    	if ( ! session()->has('token')) {
	        return redirect('/')->withWarning('Login required to view dashboard');
	    }

	    $username = $this->user()['name'];

	    return view('dashboard', array('username' => $username));

    }
}
