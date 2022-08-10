<?php

namespace App\Http\Controllers\Checklist;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Repositories\Checklist\IChecklist;

class ApproveChecklistController extends Controller
{
    protected IChecklist $checklist;

    public function __construct(IChecklist $checklist)
    {
        $this->checklist = $checklist;
    }

    public function __invoke(Checklist $checklist) {
        $this->checklist->approve($checklist);
    }
}
