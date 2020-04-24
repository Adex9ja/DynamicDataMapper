<?php
use Illuminate\Database\Eloquent\Model;
require __DIR__ . '/../../vendor/autoload.php';
class ProvidersEntity extends Model
{
    protected $table = "providers_entity";
    public $timestamps = false;
}