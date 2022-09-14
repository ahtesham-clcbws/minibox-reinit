<?php

namespace App\Entities\Emails;

use CodeIgniter\Entity\Entity;

class PasswordReset extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
