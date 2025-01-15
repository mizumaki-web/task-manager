<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // 一括割り当て可能なフィールドを定義
    protected $fillable = ['title', 'status'];
}
