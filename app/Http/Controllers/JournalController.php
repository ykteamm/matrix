<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseJournal;
class JournalController extends Controller
{
    public function purchase()
    {
        $purchases = PurchaseJournal::
        select('tg_purchase_journals.created_at','tg_purchase_journals.id','tg_purchase_journals.old','tg_purchase_journals.new','tg_medicine.name','tg_user.first_name','tg_user.last_name','tg_user.username')
        ->join('tg_user','tg_user.id','tg_purchase_journals.user_id')
        ->join('tg_productssold','tg_productssold.id','tg_purchase_journals.sold_id')
        ->join('tg_medicine','tg_medicine.id','tg_productssold.medicine_id')
        ->get();
        // return $purchases;
        return view('journal-purchase',compact('purchases'));
    }
}
