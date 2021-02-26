<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    public function indexAction()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->json($categories);
    }
}
