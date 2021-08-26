<?php

namespace App\Controller;

use App\Entity\Ingredient;
use Symfony\Component\HttpFoundation\Request;

class ImageController 
{
    public function __invoke(Ingredient $ingredient, Request $request)
    {
        $file = $request->files->get('file');
        dd($file);
    }
}