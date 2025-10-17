<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord selon le rôle de l'utilisateur
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('technician.dashboard');
        }
    }

    /**
     * Tableau de bord administrateur
     */
    public function adminDashboard()
    {
        // Statistiques générales
        $stats = [
            'total_interventions' => Intervention::count(),
            'new_requests' => Intervention::where('status', 'nouvelle_demande')->count(),
            'in_progress' => Intervention::whereIn('status', ['diagnostic', 'en_reparation'])->count(),
            'completed' => Intervention::whereIn('status', ['termine', 'non_reparable'])->count(),
            'total_clients' => Client::count(),
            'total_technicians' => User::where('role', 'technicien')->count(),
        ];

        // Interventions par statut
        $interventionsByStatus = Intervention::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Interventions par technicien
        $interventionsByTechnician = Intervention::with('assignedTechnician')
            ->whereNotNull('assigned_technician_id')
            ->select('assigned_technician_id', DB::raw('count(*) as count'))
            ->groupBy('assigned_technician_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->assignedTechnician->name => $item->count];
            });

        // Interventions par type d'appareil
        $interventionsByDevice = Intervention::select('device_type', DB::raw('count(*) as count'))
            ->groupBy('device_type')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->pluck('count', 'device_type');

        // Dernières interventions
        $recentInterventions = Intervention::with(['client', 'assignedTechnician'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Interventions non assignées
        $unassignedInterventions = Intervention::with('client')
            ->whereNull('assigned_technician_id')
            ->where('status', 'nouvelle_demande')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.admin', compact(
            'stats',
            'interventionsByStatus',
            'interventionsByTechnician',
            'interventionsByDevice',
            'recentInterventions',
            'unassignedInterventions'
        ));
    }

    /**
     * Tableau de bord technicien
     */
    public function technicianDashboard()
    {
        $technicianId = Auth::id();

        // Statistiques du technicien
        $stats = [
            'my_interventions' => Intervention::assignedTo($technicianId)->count(),
            'in_progress' => Intervention::assignedTo($technicianId)
                ->whereIn('status', ['diagnostic', 'en_reparation'])
                ->count(),
            'completed_today' => Intervention::assignedTo($technicianId)
                ->whereIn('status', ['termine', 'non_reparable'])
                ->whereDate('updated_at', today())
                ->count(),
            'pending' => Intervention::assignedTo($technicianId)
                ->where('status', 'nouvelle_demande')
                ->count(),
        ];

        // Mes interventions en cours
        $myInterventions = Intervention::with(['client', 'images'])
            ->assignedTo($technicianId)
            ->whereIn('status', ['nouvelle_demande', 'diagnostic', 'en_reparation'])
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Interventions récentes terminées
        $recentCompleted = Intervention::with('client')
            ->assignedTo($technicianId)
            ->whereIn('status', ['termine', 'non_reparable'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.technician', compact(
            'stats',
            'myInterventions',
            'recentCompleted'
        ));
    }

    /**
     * Export CSV des interventions (admin seulement)
     */
    public function exportInterventions(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $query = Intervention::with(['client', 'assignedTechnician']);

        // Appliquer les mêmes filtres que dans l'index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('device_type', 'like', "%{$search}%")
                  ->orWhereHas('client', function ($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->withStatus($request->status);
        }

        if ($request->filled('priority')) {
            $query->withPriority($request->priority);
        }

        $interventions = $query->orderBy('created_at', 'desc')->get();

        $filename = 'interventions_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($interventions) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID',
                'Client',
                'Email Client',
                'Téléphone Client',
                'Description',
                'Type d\'appareil',
                'Priorité',
                'Statut',
                'Technicien assigné',
                'Date prévue',
                'Notes internes',
                'Date de création',
                'Dernière mise à jour'
            ]);

            // Données
            foreach ($interventions as $intervention) {
                fputcsv($file, [
                    $intervention->id,
                    $intervention->client->name,
                    $intervention->client->email,
                    $intervention->client->phone,
                    $intervention->description,
                    $intervention->device_type,
                    $intervention->priority,
                    $intervention->status,
                    $intervention->assignedTechnician ? $intervention->assignedTechnician->name : 'Non assigné',
                    $intervention->scheduled_date ? $intervention->scheduled_date->format('d/m/Y H:i') : '',
                    $intervention->internal_notes,
                    $intervention->created_at->format('d/m/Y H:i'),
                    $intervention->updated_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
