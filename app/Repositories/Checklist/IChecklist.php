<?php

namespace App\Repositories\Checklist;

use App\Http\Requests\Checklist\UpdateMessageRequest;
use App\Models\Checklist;

interface IChecklist
{
    public function updateMessage(Checklist $checklist, $message);
    public function approve(Checklist $checklist);
    public function disapprove(Checklist $checklist, $message);
}
