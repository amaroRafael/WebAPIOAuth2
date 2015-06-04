<?php namespace App\OAuth2Server\Storage;

use App\Models\Oauth_refresh_token;
use Illuminate\Database\Capsule\Manager as Capsule;
use League\OAuth2\Server\Entity\RefreshTokenEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\RefreshTokenInterface;

class RefreshTokenStorage extends AbstractStorage implements RefreshTokenInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($token)
    {
        $result = Oauth_refresh_token::query()
                    ->where('refresh_token', $token)
                    ->get();

        if (count($result) === 1) {
            $token = (new RefreshTokenEntity($this->server))
                        ->setId($result[0]['refresh_token'])
                        ->setExpireTime($result[0]['expire_time'])
                        ->setAccessTokenId($result[0]['access_token']);

            return $token;
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function create($token, $expireTime, $accessToken)
    {
        Oauth_refresh_token::create([
            'refresh_token' =>  $token,
            'access_token'  =>  $accessToken,
            'expire_time'   =>  $expireTime,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(RefreshTokenEntity $token)
    {
        Oauth_refresh_token::query()
            ->where('refresh_token', $token->getId())
            ->delete();
    }
}
