<?php

namespace App\Controller;


use DateTime;
use Symfony\Component\HttpFoundation\Request;

class CategoryImageController 
{
    public function __invoke(Request $request)
    {
        $category = $request->attributes->get('data');
        $file = $request->files->get('file');
       
        $category->setImageFile($file);
        $category->setUpdatedAt(new DateTime());
        return $category;
    }
}