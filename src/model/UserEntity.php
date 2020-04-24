<?php
use Illuminate\Database\Eloquent\Model;
require __DIR__ . '/../../vendor/autoload.php';
class UserEntity extends Model
{
    protected $table = "user_entity";
    public $timestamps = false;
}