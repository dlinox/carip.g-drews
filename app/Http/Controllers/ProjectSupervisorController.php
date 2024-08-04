<?php

namespace App\Http\Controllers;

use App\Models\ProjectSupervisor;
use Illuminate\Http\Request;

class ProjectSupervisorController extends Controller
{

    protected $projectSupervisor;

    public function __construct()
    {
        $this->projectSupervisor = new ProjectSupervisor();
    }

    public function assignSupervisor(Request $request)
    {
        try {
            $this->projectSupervisor->assignProjectSupervisor($request->project_id, $request->supervisor_id);

            return response()->json([
                'message' => 'Supervisor asignado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    // unassignSupervisor
    public function unassignSupervisor(Request $request)
    {
        try {
            $projectSupervisor = $this->projectSupervisor->where('project_id', $request->project_id)->where('supervisor_id', $request->supervisor_id)->first();

            if ($projectSupervisor) {
                $projectSupervisor->delete();
            }

            return response()->json([
                'message' => 'Supervisor desasignado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getSupervisorByProject($projectId)
    {
        $supervisor = $this->projectSupervisor->getProjectSupervisor($projectId);

        //si supoervisor es un objeto vacio retornar null
        if (!$supervisor) {
            return response()->json(null);
        }

        return response()->json($supervisor);
    }
}
