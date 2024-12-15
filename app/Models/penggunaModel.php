<?php

namespace App\Models;

use CodeIgniter\Model;

class penggunaModel extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'username';
    protected $allowedFields = ['username', 'password', 'nomor'];
}