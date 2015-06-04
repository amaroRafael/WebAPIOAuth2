<?php  namespace App\Models; 
/**
 * Created by PhpStorm.
 * User: ramaro
 * Date: 6/3/15
 * Time: 9:55 PM
 */
use Illuminate\Database\Eloquent\Model;

final class Oauth_access_token_scope extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['access_token', 'scope'];

}