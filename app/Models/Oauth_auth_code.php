<?php  namespace App\Models; 
/**
 * Created by PhpStorm.
 * User: ramaro
 * Date: 6/3/15
 * Time: 9:55 PM
 */
use Illuminate\Database\Eloquent\Model;

final class Oauth_auth_code extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['auth_code', 'client_redirect_uri', 'session_id', 'expire_time'];

}