<?php

declare(strict_types=1);

namespace App\Models;

use App\Bootstrap\App;
use App\Configs\DB;

abstract class Model
{
    protected DB $db;

    public function __construct()
    {
        $this->db = App::db();
    }
}
