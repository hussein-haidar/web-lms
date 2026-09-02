<?php

namespace App\Models;

use CodeIgniter\Model;

class M_chat extends Model
{
    protected $table = 'chat';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_pengirim',
        'role_pengirim',
        'id_penerima',
        'role_penerima',
        'pesan',
        'is_read',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $returnType = 'array';
