<?php  namespace App\Models; 
/**
 * Created by PhpStorm.
 * User: ramaro
 * Date: 6/3/15
 * Time: 9:56 PM
 */
use Illuminate\Database\Eloquent\Model;

final class Oauth_auth_code_scope extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['auth_code', 'scope'];

}