<?php

namespace App\Http\Controllers;

use App\Http\Requests\Application\StoreRequest;
use App\Models\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Application::class);

        $applications = Application::with('service')
            ->paginate($request->get('perPage', 25))
            ->withQueryString();

        return Inertia::render('Application/Index', [
            'applications' => $applications
        ]);
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Application::class);

        $data = $request->validated();

        return Application::create($data);
    }

    public function create()
    {
        $this->authorize('create', Application::class);

        return Inertia::render('Application/Create');
    }

    public function show(Application $application)
    {
        $this->authorize('view', $application);

        return $application;
    }
}
