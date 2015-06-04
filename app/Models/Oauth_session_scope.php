<?php  namespace App\Models; 
/**
 * Created by PhpStorm.
 * User: ramaro
 * Date: 6/3/15
 * Time: 9:57 PM
 */
use Illuminate\Database\Eloquent\Model;

final class Oauth_session_scope extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['session_id', 'scope'];

}