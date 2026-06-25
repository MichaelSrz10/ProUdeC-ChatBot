<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Controller
{
    public function enviar(Request $request)
    {
        $request->validate([
            'nombre'  => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'asunto'  => 'required|in:diagnostico,mantenimiento,compra,asesoria',
            'mensaje' => 'required|string|max:1000',
        ]);

        return back()->with('success', 'Mensaje enviado correctamente.');
    }
}