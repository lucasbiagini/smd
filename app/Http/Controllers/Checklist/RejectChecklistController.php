<?php

namespace App\Http\Controllers\Checklist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checklist\DisapproveChecklistRequest;
use App\Models\Checklist;
use App\Repositories\Checklist\IChecklist;

class RejectChecklistController extends Controller
{
    protected IChecklist $checklist;

    public function __construct(IChecklist $checklist)
    {
        $this->checklist = $checklist;
    }

    public function __invoke(Checklist $checklist, DisapproveChecklistRequest $request) {
        $this->checklist->disapprove($checklist, $request->message);
    }
}
