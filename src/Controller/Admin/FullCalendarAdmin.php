<?php

namespace Labstag\Controller\Admin;

use Labstag\Lib\AdminControllerLib;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/fullcalendar")
 */
class FullCalendarAdmin extends AdminControllerLib
{
    /**
     * @Route("/", name="adminfullcalendar_index")
     */
    public function index(Request $request): Response
    {
        return $this->twig(
            'admin/fullcalendar.html.twig',
            ['title' => 'fullcalendar']
        );
    }
}
