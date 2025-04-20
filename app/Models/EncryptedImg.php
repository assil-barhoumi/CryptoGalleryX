<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncryptedImg extends Model
{
    use HasFactory;

    protected $table = 'encrypted_img';

    protected $fillable = [
        'user_id',
         'encrypted_data',
       'encryption_method',
    ];
    public function user()
{
    return $this->belongsTo(User :: class, 'user_id');

}
}