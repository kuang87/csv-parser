<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportCSVRequest;
use App\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class FileController extends Controller
{
    private $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function import(ImportCSVRequest $request)
    {
        $pathFile = $request->file('filename')->getRealPath();
        $file = file($pathFile);
        unset($file[0]);

        Payment::query()->delete();

        //save data to DB
        array_map('App\Payment::saveFromCsv', $file);

        //get grouped data from DB
        $payments = $this->paymentRepository->all();

        //calculate vars for view page
        $sum = $payments->reduce(function ($sum, $item){
            return $sum + $item->sum;
        });
        $sumS = $payments->filter(function ($item){
            return $item->payer == Payment::PAY_S;
        })->reduce(function ($sum, $item){
            return $sum + $item->sum;
        });
        $docTypes = $payments->map(function ($item){
            return ['doc_type' => $item->doc_type, 'doc_count' => $item->doc_count];
        })->groupBy('doc_type');
        $docTypes = $docTypes->map(function ($item){
            return $item->sum('doc_count');
        });
        $countDoc = $payments->pluck('doc_count')->sum();

        return view('result', [
            'payments' => $payments,
            'sum' => $sum,
            'sumS' => $sumS,
            'docTypes' => $docTypes,
            'countDoc' => $countDoc,
        ]);
    }
}
