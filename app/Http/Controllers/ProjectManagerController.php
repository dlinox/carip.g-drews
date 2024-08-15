<?php

namespace App\Http\Controllers;

use App\Models\ProjectManager;
use Illuminate\Http\Request;

class ProjectManagerController extends Controller
{
    protected $projectManager;

    public function __construct()
    {
        $this->projectManager = new ProjectManager();
    }

    //getManagers
    public function getCompanyManagers($companyId)
    {
        $managers = $this->projectManager->getCompanyManagers($companyId);
        return response()->json($managers);
    }

    public function getManagers($projectId)
    {
        $managers = $this->projectManager->getManagers($projectId);
        return response()->json($managers);
    }

    public function assignManager(Request $request)
    {
        try {

            $projectId = $request->project_id;
            $workerId = $request->worker_id;

            $this->projectManager->assignManager($projectId, $workerId);
            return response()->json([
                'message' => 'Supervisor asignado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function unassignManager(Request $request)
    {
        try {
            $this->projectManager->where('project_id', $request->project_id)
                ->where('worker_id', $request->worker_id)
                ->delete();

            return response()->json([
                'message' => 'Responsable desasignado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
