<?php


namespace App\Repositories;


use App\Repositories\Interfaces\PaymentRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PaymentRepository implements PaymentRepositoryInterface
{

    public function all()
    {
        return DB::table('payments')
            ->select(['sender', 'receiver', 'payer', 'doc_type', DB::raw('SUM(sum) as sum, SUM(count) as count, COUNT(doc_type) as doc_count')])
            ->groupBy(['sender', 'receiver', 'doc_type', 'payer'])->get();
    }
}
