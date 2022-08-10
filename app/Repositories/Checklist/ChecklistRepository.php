<?php

namespace App\Repositories\Checklist;

use App\Http\Requests\Checklist\UpdateMessageRequest;
use App\Models\Checklist;
use Carbon\Carbon;

class ChecklistRepository implements IChecklist
{
    public function updateMessage(Checklist $checklist, $message)
    {
        $checklist->message = $message;
        $checklist->save();
    }

    public function approve(Checklist $checklist)
    {
        $checklist->approved = 1;
        if ($checklist->message !== null) $checklist->message = null;
        $checklist->save();
    }

    public function disapprove(Checklist $checklist, $message)
    {
        $checklist->approved = 0;
        $checklist->message = $message;
        $checklist->save();
    }
}
