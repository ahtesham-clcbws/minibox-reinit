<?php

namespace App\Models\Events;

use CodeIgniter\Model;

class EventTicketRegistration extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'event_ticket_registrations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'event_id',
        'event_type',
        'module_id',
        'ticket_ids',

        'receipt',
        'name',
        'email',
        'whatsapp',
        'mobile',
        'address',
        'country',
        'state',
        'city',
        'pin',
        'package_details',
        'tickets',
        'order_id',
        'amount',
        'gateway',
        'gateway_order_id',
        'payment_status',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
