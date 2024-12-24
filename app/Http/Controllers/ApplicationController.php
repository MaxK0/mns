<?php

namespace App\Http\Controllers;

use App\Enums\PaymentEnum;
use App\Http\Requests\Application\StoreRequest;
use App\Models\Application;
use App\Models\Service;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Application::class);

        $user = auth()->user();

        $applications = $user->applications()
            ->with('service')
            ->orderByDesc('id')
            ->paginate($request->get('perPage', 20))
            ->withQueryString();

        return Inertia::render('Application/Index', [
            'applications' => $applications
        ]);
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Application::class);

        $data = $request->validated();

        if ($data['is_another_service']) $data['service_id'] = null;
        else $data['service_inf'] = null;

        $data['user_id'] = auth()->user()->id;

        Application::create($data);

        return redirect()->route('applications.index');
    }

    public function create()
    {
        $this->authorize('create', Application::class);

        $services = Service::all();
        $paymentTypes = PaymentEnum::toArray();

        return Inertia::render('Application/Create', [
            'services' => $services,
            'paymentTypes' => $paymentTypes
        ]);
    }

    public function show(Application $application)
    {
        $this->authorize('view', $application);

        return $application;
    }
}
