<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'username';
    protected $allowedFields = ['username', 'password', 'nomor'];
}