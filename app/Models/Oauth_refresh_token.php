<?php  namespace App\Models; 
/**
 * Created by PhpStorm.
 * User: ramaro
 * Date: 6/3/15
 * Time: 9:54 PM
 */
use Illuminate\Database\Eloquent\Model;

final class Oauth_refresh_token extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['refresh_token', 'access_token', 'expire_time'];

}