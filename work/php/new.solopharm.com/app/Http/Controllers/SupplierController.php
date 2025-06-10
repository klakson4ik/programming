<?php

namespace App\Http\Controllers;

use App\Models\Pages\ProviderPage;
use App\Services\BreadcrumbService;
use App\Services\MailService;
use App\Services\MetaService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $page = ProviderPage::getPage();

        $data = [
            'asset' => 'supplier',
            'page' => $page,
            'meta' => MetaService::getData($page),
            'breadcrumbsAdd' => BreadcrumbService::addBreadcrumbs(
                [[
                    'name' => __('pages.breadcrumbs.become-supplier'),
                    'url' => '/'
                ]]
            )
        ];

        return view('supplier', $data);
    }


    public function store(Request $request)
    {
        $subject = __('pages.mail.supplier.subject');
        $body = MailService::getBody(
            [
                '<b>' . __('form.supplier.grotex') . ': </b>' . $request->sup_grotex,
                '<b>' . __('form.supplier.resident') . ': </b>' . $request->resident,
                '<b>' . __('form.supplier.supply-cat') . ': </b>' . $request->supply_cat,
                '<b>' . __('form.supplier.company') . ': </b>' . $request->company,
                '<b>' . __('form.supplier.type-company.name') . ': </b>' . $request->type_company,
                '<b>' . __('form.supplier.INN') . ': </b>' . $request->INN,
                '<b>' . __('form.supplier.legal-address') . ': </b>' . $request->legal_address,
                '<b>' . __('form.supplier.actual-address') . ': </b>' . $request->actual_address,
                '<b>' . __('form.supplier.system-quality') . ': </b>' . $request->system_quality,
                '<b>' . __('form.supplier.person') . ': </b>' . $request->person,
                '<b>' . __('form.supplier.job') . ': </b>' . $request->job,
                '<b>' . __('form.email') . ': </b>' . $request->email,
                '<b>' . __('form.phone') . ': </b>' . $request->phone,
                '<b>' . __('form.supplier.work-phone') . ': </b>' . $request->work_phone,
            ],
            $subject
        );
        $headers = MailService::getHeaders($request->email, $request->person);
        mail(config('constant.mail.tender'), $subject, $body, $headers);

        return back()->with('status', 'send');
    }
}
