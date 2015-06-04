<?php namespace App\OAuth2Server\Storage;

use App\Models\Oauth_session;
use App\Models\Oauth_session_scope;
use Illuminate\Database\Capsule\Manager as Capsule;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\SessionInterface;

class SessionStorage extends AbstractStorage implements SessionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getByAccessToken(AccessTokenEntity $accessToken)
    {
        $result = Oauth_session::query()
                    ->select(['oauth_sessions.id', 'oauth_sessions.owner_type', 'oauth_sessions.owner_id', 'oauth_sessions.client_id', 'oauth_sessions.client_redirect_uri'])
                    ->join('oauth_access_tokens', 'oauth_access_tokens.session_id', '=', 'oauth_sessions.id')
                    ->where('oauth_access_tokens.access_token', $accessToken->getId())
                    ->get();

        if (count($result) === 1) {
            $session = new SessionEntity($this->server);
            $session->setId($result[0]['id']);
            $session->setOwner($result[0]['owner_type'], $result[0]['owner_id']);

            return $session;
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getByAuthCode(AuthCodeEntity $authCode)
    {
        $result = Oauth_session::query()
                    ->select(['oauth_sessions.id', 'oauth_sessions.owner_type', 'oauth_sessions.owner_id', 'oauth_sessions.client_id', 'oauth_sessions.client_redirect_uri'])
                    ->join('oauth_auth_codes', 'oauth_auth_codes.session_id', '=', 'oauth_sessions.id')
                    ->where('oauth_auth_codes.auth_code', $authCode->getId())
                    ->get();

        if (count($result) === 1) {
            $session = new SessionEntity($this->server);
            $session->setId($result[0]['id']);
            $session->setOwner($result[0]['owner_type'], $result[0]['owner_id']);

            return $session;
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getScopes(SessionEntity $session)
    {
        $result = Oauth_session::query()
                    ->select('oauth_scopes.*')
                    ->join('oauth_session_scopes', 'oauth_sessions.id', '=', 'oauth_session_scopes.session_id')
                    ->join('oauth_scopes', 'oauth_scopes.id', '=', 'oauth_session_scopes.scope')
                    ->where('oauth_sessions.id', $session->getId())
                    ->get();

        $scopes = [];

        foreach ($result as $scope) {
            $scopes[] = (new ScopeEntity($this->server))->hydrate([
                'id'            =>  $scope['id'],
                'description'   =>  $scope['description'],
            ]);
        }

        return $scopes;
    }

    /**
     * {@inheritdoc}
     */
    public function create($ownerType, $ownerId, $clientId, $clientRedirectUri = null)
    {
        $id = Oauth_session::create([
            'owner_type'  =>    $ownerType,
            'owner_id'    =>    $ownerId,
            'client_id'   =>    $clientId,
        ]);

        return $id;
    }

    /**
     * {@inheritdoc}
     */
    public function associateScope(SessionEntity $session, ScopeEntity $scope)
    {
        Oauth_session_scope::create([
            'session_id'    =>  $session->getId(),
            'scope'         =>  $scope->getId(),
        ]);
    }
}
