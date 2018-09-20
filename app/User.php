<?php

namespace App;

use App\Models\Role;
use App\Models\User_Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','referer_id','phone'
    ];

    public function getUserBonus(){
        return $this->hasOne('App\Models\user_bonus', 'user_id', 'id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /****/
    /**
     * Функция для получения названия роли к которой пользователь принадлежит.
     *
     * @return boolean
     **/
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'users_roles', 'user_id', 'role_id');
    }
    /**
     * Проверка принадлежит ли пользователь к какой либо роли
     *
     * @return boolean
     */
    public function isEmployee()
    {
        $roles = $this->roles->toArray();
        return !empty($roles);
    }
    /**
     * Проверка имеет ли пользователь определенную роль
     *
     * @return boolean
     */
    public function hasRole($check)
    {
        return in_array($check, array_pluck($this->roles->toArray(), 'name'));
        // начиная с версии 5.1 метода array_fetch не существует
        //return in_array($check, array_fetch($this->roles->toArray(), 'name'));
    }

    /**
     * Получение идентификатора роли
     *
     * @return int
     */
    private function getIdInArray($array, $term)
    {
        foreach ($array as $key => $value) {
            if ($value == $term) {
                return $key + 1;
            }
        }
        return false;
    }

    public static function getUserName($user){
        return $user->name;
    }

    public static function UserRoleName($id)
    {
        $table = User_Role::where('user_id',$id)->get();
        return Role::all()->find($table[0]->role_id)->name;
    }

    public static function UserRoleDisplayName($id)
    {
        $table = User_Role::where('user_id',$id)->get();
        return Role::all()->find($table[0]->role_id)->display_name;
    }
    
     public function phone()
     {
         return $this->hasOne('App\Phone');
    }

}
