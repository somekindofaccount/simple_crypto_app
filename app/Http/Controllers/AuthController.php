<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\HandlesOAuthErrors;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;
use Illuminate\Support\Facades\Session;
use Helper;

class AuthController extends Controller
{
    use HandlesOAuthErrors;

    /**
     * 
     * The authorization server.
     *
     * @var AuthorizationServer
     */
    protected $server;

    /**
     * The token repository instance.
     *
     * @var TokenRepository
     */
    protected $tokens;

    /**
     * The JWT parser instance.
     *
     * @var JwtParser
     */
    protected $jwt;

    /**
     * Create a new controller instance.
     *
     * @param  AuthorizationServer  $server
     * @param  TokenRepository  $tokens
     * @param  JwtParser  $jwt
     * @return void
     */
    public function __construct(AuthorizationServer $server, TokenRepository $tokens, JwtParser $jwt) {

        $this->jwt = $jwt;
        $this->server = $server;
        $this->tokens = $tokens;
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request     $request
     * @return \Illuminate\Http\Response
     */
    public function issueToken(ServerRequestInterface $request)
    {	
        return $this->withErrorHandling(function () use ($request) {
            return $this->server->respondToAccessTokenRequest($request, new Psr7Response);
        });
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request     $request
     * @return \Illuminate\Http\Response
     */
    public function getAuthenticatedUser() {
        
        $user =  Auth::user()->toArray();
        $role_perm_data = Helper::UserRolesWithPerms(Auth::user());
        $user['roles'] = $role_perm_data['roles'];

        return response()->json($user);
    }

    /**
     *
     * @param  \Illuminate\Http\Request     $request
     * @return \Illuminate\Http\Response
     */
    public function refreshToken(ServerRequestInterface $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            return $this->server->respondToAccessTokenRequest($request, new Psr7Response);
        });
    }

    /**
     * [logout description]
     * 
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function logout(ServerRequestInterface $request, Request $req)
    {   

        if (!Auth::guard('api')->check()) {
            return response([
                'message' => 'No active user session was found'
            ], 404);
        }

        // Taken from: https://laracasts.com/discuss/channels/laravel/laravel-53-passport-password-grant-logout
        $req->user('api')->token()->revoke();

        //Auth::guard('api')->logout();
        Session::flush();
        Session::regenerate();

        return response([
            'message' => 'User was logged out'
        ]);
        
        
    }
}