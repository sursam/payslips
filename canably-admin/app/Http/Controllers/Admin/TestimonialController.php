<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\Role\RoleService;
use App\Services\Testimonial\TestimonialService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimonialController extends BaseController
{

    protected $roleService;

    protected $userService;
    protected $testimonialService;

    public function __construct(
        UserService $userService,
        RoleService $roleService,
        TestimonialService $testimonialService
    ) {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->testimonialService = $testimonialService;
    }
    public function index(Request $request)
    {
        $this->setPageTitle('All Testimonial');
        $filterConditions = [];
        $listTestimonials = $this->testimonialService->listTestimonials($filterConditions, 'id', 'asc', 15);
        return view('admin.testimonial.index', compact('listTestimonials'));
    }

    public function addTestimonialReviews(Request $request)
    {
        $this->setPageTitle('Add Testimonial');
        /* dd($listUsers); */
        return view('admin.testimonial.add');
    }

    public function store(Request $request)
    {
        if ($request->post()) {
            $this->validate($request, [
                'name' => 'required|min:2',
                'product'=> 'required|string|min:2',
                'comment' => 'required|string|min:3',
                'testimonial_image' => 'required|file|image|mimes:jpg,png,jpeg,gif,svg',
            ]);
            DB::beginTransaction();
            try {
                $isTestimonialCreated = $this->testimonialService->createOrUpdateTestimonial($request->except('_token'));
                if ($isTestimonialCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.testimonial.list', 'Testimonial created Successfully', 'success', false, false);
                }
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
    }

    public function editTestimonialReviews(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Testimonial');
        $id = uuidtoid($uuid, 'testimonials');
        $testimonial = $this->testimonialService->findTestimonialById($id);

        if ($request->post()) {
            $this->validate($request, [
                'name' => 'required|min:2',
                'product'=> 'required|string|min:2',
                'comment' => 'required|string|min:3',
                'testimonial_image' => 'sometimes|file|image|mimes:jpg,png,jpeg,gif,svg',
            ]);
            // dd('here');
            DB::beginTransaction();
            try {
                $isTestimonialUpdated = $this->testimonialService->createOrUpdateTestimonial($request->except(['_token']), $id);
                if ($isTestimonialUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.testimonial.list', 'Testimonial updated successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.testimonial.edit', compact('testimonial'));
    }

}
