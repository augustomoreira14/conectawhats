<?php

namespace App\Http\Controllers\Dashboard;

use App\ConectaWhats\SideDish\Application\StoreHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ConectaWhats\SideDish\Domain\Models\Message\Message;
use App\ConectaWhats\SideDish\Domain\Models\Order\Flow;
/**
 * Description of MessageController
 *
 * @author augus
 */
class MessageController extends Controller
{
    public function index(Request $req)
    {
        $messages = Message::where('store_id', StoreHelper::currentStoreId())->get();

        $types = Flow::all();
        $typesMessages = $messages->groupBy('flow');
        foreach($types as $type){
            if(!isset($typesMessages[$type])){
                $typesMessages[$type] = [];
            }
        }

        return view('dashboard.messages.index', compact('types', 'typesMessages'));
    }

    public function getMessages(Request $req)
    {
        $query = Message::where('store_id', StoreHelper::currentStoreId());
        if($req->flow){
            $query->where('flow', $req->flow);
        }

        return response()->json($query->get());
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'title' => 'string|required',
            'content' => 'string|required',
            'flow' => 'string|required',
        ]);

        Message::create([
            'title' => $req->title,
            'content' => $req->get('content'),
            'flow' => new Flow($req->flow),
            'store_id' => StoreHelper::currentStoreId()
        ]);

        return redirect()->back()->with('message', 'Cadastrado com sucesso.');
    }

    public function update(Request $req, $id)
    {
        $this->validate($req, [
            'content' => 'string|required',
        ]);

        $message = Message::findOrFail($id);
        $message->fill($req->only(['title','content']));
        $message->save();

        return redirect()->back()->with('message', 'Atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        return redirect()->back()->with('message', 'Deletado com sucesso.');
    }
        
}
