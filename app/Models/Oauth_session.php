<?php  namespace App\Models; 
/**
 * Created by PhpStorm.
 * User: ramaro
 * Date: 6/3/15
 * Time: 9:52 PM
 */
use Illuminate\Database\Eloquent\Model;

final class Oauth_session extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['owner_type', 'owner_id', 'client_id'];

}