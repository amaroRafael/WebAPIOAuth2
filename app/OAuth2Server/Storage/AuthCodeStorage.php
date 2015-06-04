<?php namespace App\OAuth2Server\Storage;

use App\Models\Oauth_auth_code;
use App\Models\Oauth_auth_code_scope;
use Illuminate\Database\Capsule\Manager as Capsule;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\AuthCodeInterface;

class AuthCodeStorage extends AbstractStorage implements AuthCodeInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($code)
    {
        $result = Oauth_auth_code::query()
                    ->where('auth_code', $code)
                    ->where('expire_time', '>=', time())
                    ->get();

        if (count($result) === 1) {
            $token = new AuthCodeEntity($this->server);
            $token->setId($result[0]['auth_code']);
            $token->setRedirectUri($result[0]['client_redirect_uri']);
            $token->setExpireTime($result[0]['expire_time']);

            return $token;
        }

        return;
    }

    public function create($token, $expireTime, $sessionId, $redirectUri)
    {
        Oauth_auth_code::create([
                        'auth_code'            =>  $token,
                        'client_redirect_uri'  =>  $redirectUri,
                        'session_id'           =>  $sessionId,
                        'expire_time'          =>  $expireTime,
                    ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getScopes(AuthCodeEntity $token)
    {
        $result = Oauth_auth_code_scope::query()
                    ->select(['oauth_scopes.id', 'oauth_scopes.description'])
                    ->join('oauth_scopes', 'oauth_auth_code_scopes.scope', '=', 'oauth_scopes.id')
                    ->where('auth_code', $token->getId())
                    ->get();

        $response = [];

        if (count($result) > 0) {
            foreach ($result as $row) {
                $scope = (new ScopeEntity($this->server))->hydrate([
                    'id'            =>  $row['id'],
                    'description'   =>  $row['description'],
                ]);
                $response[] = $scope;
            }
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function associateScope(AuthCodeEntity $token, ScopeEntity $scope)
    {
        Oauth_auth_code_scope::create([
            'auth_code' =>  $token->getId(),
            'scope'     =>  $scope->getId(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(AuthCodeEntity $token)
    {
        Oauth_auth_code::query()
            ->where('auth_code', $token->getId())
            ->delete();
    }
}
