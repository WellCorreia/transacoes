<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'transactions';

    protected $primaryKey = 'id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'payer_id',
        'payee_id',
    ];


    public function payer()
    {
        return $this->hasOne(User::class, 'id', 'payer_id');
    }

    public function payee()
    {
        return $this->hasOne(User::class, 'id', 'payee_id');
    }
}
