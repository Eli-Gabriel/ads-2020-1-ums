<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ambiente;
use App\Sgbd;

class AmbienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ambientes = Ambiente::list();
        
        return view('ambiente.list', array('ambientes' => $ambientes));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sgbds = Sgbd::All();
        return view('ambiente.create', array('sgbds' => $sgbds));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ambiente = Ambiente::create($request->all());
        
        return redirect('ambientes')->with('status', 'Ambiente cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ambiente = Ambiente::find($id);
        $sgbds = Sgbd::All();
        return view ('ambiente.edit', array('ambiente' => $ambiente), array('sgbds' => $sgbds));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ambiente = Ambiente::find($id);
        $ambiente->update($request->all());

        return redirect('ambientes')->with('status', 'Ambiente atualizado com sucesso!');
    }

    /**
     * Confirmação se pretende realmente o ambiente.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm($id)
    {
        $ambiente = Ambiente::getDataToConfirm($id);
        
        if ($ambiente['0']->QTD_ACESSOS > 0) {
            $mensagem = 'Deseja realmente deletar o ambiente '. $ambiente['0']->NOME  .' ? Atualmente existem {{ $ambiente["0"]->QTD_ACESSOS }} acessos cadastrados ao mesmo!';    
        } else {
            $mensagem = 'Deseja realmente deletar o ambiente '.  $ambiente['0']->NOME  .' ?';
        }

        $ambiente = Ambiente::find($id);

        return view('ambiente.confirm', array('ambiente' => $ambiente), array('mensagem' => $mensagem)); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ambiente = Ambiente::find($id);
        $ambiente->delete();

        return redirect('ambientes')->with('sucess', 'Ambiente {$ambiente->NOME} deletado com sucesso!');
    }
}
