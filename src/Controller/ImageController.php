<?php

namespace App\Controller;

use App\Entity\Ingredient;
use Symfony\Component\HttpFoundation\Request;

class ImageController 
{
    public function __invoke(Request $request)
    {
        $ingredient = $request->attributes->get('data');
        $file = $request->files->get('file');
        dd($file);
    }
}