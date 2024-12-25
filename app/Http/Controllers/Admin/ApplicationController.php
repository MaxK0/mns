<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Application\UpdateRequest;
use App\Http\Requests\Admin\Application\UpdateStatusRequest;
use App\Models\Application;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $applicationsQ = Application::with([
            'service' => fn($q) => $q->select('id', 'title'),
            'user' => fn($q) => $q->select('id', 'fio'),
        ])
            ->orderByDesc('id');

        $status = $request->get('status');

        if ($status || $status === '0') {
            $applicationsQ->where('status', $status);
        }

        $serviceId = $request->get('service_id');

        if ($serviceId) {
            $applicationsQ->where('service_id', $serviceId);
        }

        $applications = $applicationsQ
            ->paginate($request->get('perPage', 20))
            ->withQueryString();

        $statuses = StatusEnum::toArray();
        $statuses = array_merge([['id' => null, 'label' => 'Все статусы']], $statuses);

        $services = Service::select('id', 'title')->get();
        $services->prepend(['id' => null, 'title' => 'Все услуги']);

        return Inertia::render('Admin/Application/Index', [
            'applications' => $applications,
            'statuses' => $statuses,
            'services' => $services,
            'status' => $status,
            'service_id' => $serviceId,
        ]);
    }

    public function show(Application $application)
    {
        $application->load(['service', 'user']);

        return Inertia::render('Admin/Application/Show', [
            'application' => $application
        ]);
    }

    public function edit(Application $application)
    {
        $application->load([
            'service'
        ]);

        $statuses = StatusEnum::toArray();
        $paymentTypes = PaymentEnum::toArray();
        $services = Service::all();

        return Inertia::render('Admin/Application/Edit', [
            'application' => $application,
            'statuses' => $statuses,
            'paymentTypes' => $paymentTypes,
            'services' => $services,
        ]);
    }

    public function destroy(Application $application)
    {
        $application->delete();

        return redirect()->route('admin.applications.index');
    }

    public function destroyWithoutRedirect(Application $application)
    {
        $application->delete();
    }

    public function updateStatus(UpdateStatusRequest $request, Application $application)
    {
        $data = $request->validated();

        $application->update($data);
    }

    public function update(UpdateRequest $request, Application $application)
    {
        $data = $request->validated();

        if ($data['is_another_service']) {
            $data['service_id'] = null;
        } else {
            $data['service_inf'] = null;
        }

        if ($data['status'] != StatusEnum::Cancelled->value) {
            $data['reason_for_cancel'] = null;
        }

        $application->update($data);

        return redirect()->route('admin.applications.index');
    }
}
