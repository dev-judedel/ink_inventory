<?php
namespace App\Controllers;

use App\Models\{InkItem, InkBatch, InkMovement};
use App\Services\InkInventoryService;
use Core\Request; use Core\Response; use Core\Auth;

class InkInventoryController extends Controller
{
    protected InkInventoryService $svc;
    public function __construct() { $this->svc = new InkInventoryService(); }

    public function index()
    {
        $items = InkItem::where('is_active',1)->orderBy('name','asc')->paginate(25);
        return view('ink/index', compact('items'));
    }

    public function show($id)
    {
        $item = InkItem::findOrFail($id);
        $batches = $item->batches();
        $movements = InkMovement::where('item_id',$id)->orderBy('txn_date','desc')->limit(100)->get();
        $onHand = $item->onHand();
        $avgCost = $this->svc->currentAvgCost($item->id);
        return view('ink/show', compact('item','batches','movements','onHand','avgCost'));
    }

    public function store()
    {
        $data = Request::only(['sku','name','brand','color','printer_models','uom','reorder_point']);
        $item = new InkItem($data); $item->save();
        return Response::redirect('/ink/'.$item->id)->with('success','Ink item created');
    }

    public function receive($id)
    {
        $qty = (int)Request::input('qty');
        $unitCost = (float)Request::input('unit_cost');
        $opts = [
            'batch_no' => Request::input('batch_no'),
            'supplier' => Request::input('supplier'),
            'expiry_date' => Request::input('expiry_date'),
            'received_at' => Request::input('received_at'),
            'ref_no' => Request::input('ref_no'),
            'doc_type' => 'RCV',
            'location' => Request::input('location'),
            'note' => Request::input('note'),
            'user_id' => Auth::id(),
        ];
        $this->svc->receive($id, $qty, $unitCost, $opts);
        return Response::redirect('/ink/'.$id)->with('success','Stock received');
    }

    public function issue($id)
    {
        $qty = (int)Request::input('qty');
        $opts = [
            'ref_no' => Request::input('ref_no'),
            'doc_type' => 'ISS',
            'location' => Request::input('location'),
            'note' => Request::input('note'),
            'user_id' => Auth::id(),
        ];
        $this->svc->issue($id, $qty, $opts);
        return Response::redirect('/ink/'.$id)->with('success','Stock issued');
    }

    public function adjust($id)
    {
        $delta = (int)Request::input('qty_delta');
        $opts = [
            'ref_no' => Request::input('ref_no'),
            'doc_type' => 'ADJ',
            'location' => Request::input('location'),
            'note' => Request::input('note'),
            'user_id' => Auth::id(),
        ];
        $this->svc->adjust($id, $delta, $opts);
        return Response::redirect('/ink/'.$id)->with('success','Stock adjusted');
    }

    public function reorder()
    {
        $rows = $this->svc->reorderCandidates();
        return view('ink/reorder', ['items'=>$rows]);
    }
}