<?php

namespace App\Http\Controllers\Checklist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checklist\UpdateMessageRequest;
use App\Models\Checklist;
use App\Repositories\Checklist\IChecklist;

class UpdateMessageController extends Controller
{
    protected IChecklist $checklist;

    public function __construct(IChecklist $checklist)
    {
        $this->checklist = $checklist;
    }

    public function __invoke(Checklist $checklist, UpdateMessageRequest $request) {
        $this->checklist->updateMessage($checklist, $request->message);
    }
}
