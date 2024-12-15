<?php

namespace App\Models;

use CodeIgniter\Model;

class otpModel extends Model {
    protected $table = 'otp';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nomor', 'otp', 'waktu'];

}