<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\Faq\FaqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqController extends BaseController
{

    protected $faqService;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }

    public function index()
    {
        $this->setPageTitle('All Faqs');
        $filterConditions = [];
        $listFaqs = $this->faqService->listFaqs($filterConditions, 'id', 'asc', 15);
        return view('admin.faq.index' , compact('listFaqs'));
    }

    public function addFaq(Request $request)
    {
        $this->setPageTitle('Add Faq');
        if ($request->post()) {
            $request->validate([
                'question'      => 'required|string|unique:faqs,question',
                "answer"        => 'required'
            ]);
            DB::beginTransaction();
            try {
                $isFaqCreated = $this->faqService->createOrUpdateFaq($request->except('_token'));
                if ($isFaqCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.faq.list', 'Faq created successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.faq.add');
    }

    public function editFaq(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Faq');
        $faqId = uuidtoid($uuid, 'faqs');
        $faqData = $this->faqService->findFaqById($faqId);
        if ($request->post()) {
            $request->validate([
                'question' => 'required|string|unique:faqs,question,' . $faqId,
                "answer"   => 'required',
            ]);
            DB::beginTransaction();
            try {
                $isFaqUpdated = $this->faqService->createOrUpdateFaq($request->except('_token'), $faqId);
                if ($isFaqUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.faq.list', 'Faq updated successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }

        }
        return view('admin.faq.edit', compact('faqData'));
    }

}
