<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resource;
use App\Http\Voter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class VoteController extends Controller
{
    public function  __invoke(Request $request, Resource $resource)
    {
        //buscar o crear al votante 
        $voterId = $request->cookie('voter_code');
        $voter = Voter::where('code', $voterId)->first();

        if(!$voter){
            $voter = Voter::create([
                'code' => Str::random(30),
            ]);
            Cookie::queue('voter_code', $voter->code, 60 * 24 * 30);
        }
        //toggle del voto
        $resource->votes()->toggle($voter->id);  
        //devolverle el resource actualizado con su recuento de votos 
        return $resource->load('votes', 'category');
    }
}