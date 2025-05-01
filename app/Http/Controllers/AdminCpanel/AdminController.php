<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Contracts\AdminContract;
use App\DataTransferObjects\Admin\{AdminDataTransfer, AdminFilterDataTransfer};
use App\Http\Requests\AdminRequest;
use App\Models\{Admin, Permission, UserPermission};
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class AdminController extends Controller
{
    public function __construct(protected AdminContract $adminContract)
    {
        $this->middleware(function ($request, $next) {
            if (!can('admins')) {
                return redirect()->back()->with('permissions', __('cp.no_permission'));
            }
            return $next($request);
        })->except(['editMyProfile', 'updateProfile', 'changeMyPassword', 'updateMyPassword']);
    }

    public function index(): View
    {
        $adminDtoFilter = AdminFilterDataTransfer::fromRequest(request());
        $items = $this->adminContract->getAdmins($adminDtoFilter);
        return view('adminCpanel.admins.home', compact('items'));
    }

    public function create(): View
    {
        $role = $this->getPermissions();
        return view('adminCpanel.admins.create', compact('role'));
    }

    public function store(AdminRequest $request): RedirectResponse
    {
        return $this->handleAdminAction($request, fn($dto) => $this->adminContract->createAdmin($dto), 'cp.create');
    }

    public function edit($id): View
    {
        $item = $this->getAdminById($id);
        $role = $this->getPermissions();
        $userRole = optional(UserPermission::where('user_id', $item->id)->first());
        $userRoleItem = $userRole->permission ? explode(',', $userRole->permission) : [];

        return view('adminCpanel.admins.edit', compact('item', 'role', 'userRoleItem'));
    }

    public function update(AdminRequest $request, $id = null): RedirectResponse
    {
        $admin = $this->getAdminById($id);
        return $this->handleAdminAction($request, fn($dto) => $this->adminContract->updateAdmin($admin, $dto));
    }

    public function edit_password($id): View
    {
        $item = $this->getAdminById($id);
        return view('adminCpanel.admins.edit_password', compact('item'));
    }

    public function update_password(AdminRequest $request, $id = null): RedirectResponse
    {
        $admin = $this->getAdminById($id);
        return $this->handleAdminAction($request, fn($dto) => $this->adminContract->updateMyPassword($admin, $dto));
    }

    public function editMyProfile(): View
    {
        $item = $this->getAdminById();
        return view('adminCpanel.admins.edit_profile', compact('item'));
    }

    public function changeMyPassword(): View
    {
        $item = $this->getAdminById();
        return view('adminCpanel.admins.changeMyPassword', compact('item'));
    }

    private function getAdminById($id = null): Admin
    {
        $id = $id ?? auth()->guard('admin')->user()->id;
        return $this->adminContract->getAdmin($id);
    }

    private function getPermissions(): Collection
    {
        return Permission::get();
    }

    private function handleAdminAction(AdminRequest $request, callable $action, string $successMessage = 'cp.update'): RedirectResponse
    {
        try {
            $dataDTOAdmin = AdminDataTransfer::fromRequest($request);
            $action($dataDTOAdmin);
            return redirect()->back()->with('status', __($successMessage));
        } catch (InvalidArgumentException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
