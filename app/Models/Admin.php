<?php
namespace App\Models;


header('Content-Type: application/php');
header(json_decode('application/php'));


use App\Http\Controllers\Admincontroller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use  App\Http\Requests\AdminRequest;

class Admin extends Model
{
    protected $table = 'admin';
}
