<?php

namespace App\Models\Common;

use CodeIgniter\Model;

class LogsModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'type',
        'task',
        'content',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function createLog($type, $task, $content, $status = 0)
    {
        $log = [
            'type' => $type,
            'task' => $task,
            'content' => $content,
            'status' => $status
        ];
        return $this->save($log);
    }
}
