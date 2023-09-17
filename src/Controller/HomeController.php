<?php

namespace App\Controller;

use App\Widget;
use Prushak\Framework\Controller\AbstractController;
use Prushak\Framework\Http\Response;

class HomeController extends AbstractController
{
    public function __construct(private Widget $widget)
    {
    }

    public function index(int $id): Response
    {
        return $this->render("index.html.twig");
    }
}